<?php namespace ScubaClick\Forums\Models;

use DB;
use URL;
use View;
use Auth;
use Input;
use Config;
use Request;
use DateTime;
use Purifier;
use Paginator;
use Illuminate\Support\Str;
use ScubaClick\Forums\Pagination\Presenter;
use ScubaClick\Feeder\Contracts\FeedInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Topic extends Model implements FeedInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topics';

    /**
     * Enables model trashing/restoring
     *
     * @var bool
     */
    protected $softDelete = true;

    /**
     * Defining fillable attributes on the model
     *
     * @var array
     */
    protected $fillable = array(
    	'status',
        'forum_id',
    	'title',
    	'content',
        'sticky',
        'edited_at',
    );

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = array(
        'user_id'  => 'required|exists:users,id',
        'forum_id' => 'required|exists:forums,id',
        'status'   => 'required|in:open,resolved',
        'title'    => 'required|min:3',
        'content'  => 'required|min:8',
        'slug'     => 'required|min:3|unique:topics,slug,{id}',
        'ip'       => 'required|ip',
        'sticky'   => 'between:0,1',
	);

   /**
     * Listen for save/deleted/restored events
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            $model->user_id = empty($model->user_id) ? Auth::user()->id : $model->user_id;
            $model->content = Purifier::clean($model->content);
            $model->ip      = empty($model->ip) ? Request::getClientIp() : $model->ip;

            if($model->isDirty('title')) {
                $model->setAttribute('slug', $model->getUniqueSlug($model->getAttribute('title')));
            }

            return $model->validate();
        });

        static::updating(function($model)
        {
            $model->edited_at = new DateTime;
        });
    }

    /**
     * Register a canReply model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function canReply($callback)
    {
        static::registerModelEvent('canReply', $callback);
    }

    /**
     * Register a canEdit model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function canEdit($callback)
    {
        static::registerModelEvent('canEdit', $callback);
    }

    /**
     * Get a topic by its slug
     *
     * @param  string $slug
     * @param  mixed  $forum
     * @return object
     */
    public static function findBySlug($slug, $forum)
    {
        $topic = static::with('replies', 'forum', 'labels')
            ->where('slug', $slug)
            ->first();

        if(is_null($topic) || $topic->forum->slug != $forum) {
            throw new ModelNotFoundException;
        }

        return $topic;
    }

    /**
     * Get the search query
     *
     * @param  object $query
     * @param  string $search
     * @return string
     */
    public function scopeSearch($query, $search)
    {
        $search = urldecode($search);

        return $query->distinct()
            ->select('topics.*')
            ->join('replies', 'topics.id', '=', 'replies.topic_id')
            ->where('topics.content', 'like', "%$search%")
            ->where('topics.title', 'like', "%$search%")
            ->orWhere('replies.content', 'like', "%$search%");
    }

    /**
     * Connect the forum
     *
     * @return object
     */
    public function forum()
    {
        return $this->belongsTo('\\ScubaClick\\Forums\\Models\\Forum');
    }

    /**
     * Connect the replies
     *
     * @return object
     */
    public function replies()
    {
        return $this->hasMany('\\ScubaClick\\Forums\\Models\\Reply');
    }

    /**
     * Connect the labels
     *
     * @return object
     */
    public function labels()
    {
        return $this->belongsToMany('\\ScubaClick\\Forums\\Models\\Label');
    }

    /**
     * Connect the creator
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(Config::get('auth.model'));
    }

    /**
     * Save any labels
     *
     * @param mixed $labels
     * @return void
     */
    public function attachLabels($labels)
    {
        if(!is_array($labels)) {
            $labels = explode(',', $labels);
        }

        $labels = array_filter(array_map('trim', $labels));

        // remove all exiting labels if any
        if(count($labels) <= 0) {
            $this->labels()->sync([]);
            return;
        }

        $labelIds = array();
        foreach($labels as $title) {
            $label = Label::where('title', $title)->first();

            if(!$label) {
                $label = Label::create([
                    'title' => $title,
                    'slug'  => Str::slug($title)
                ]);

                if(!$label->isSaved()) {
                    continue;
                }
            }

            $labelIds[] = $label->id;
        }

        // sync all existing labels
        if(count($labelIds) > 0) {
            $this->labels()->sync($labelIds);
        }
    }

    /**
     * Determine if the topic has any labelss attached
     *
     * @return boolean
     */
    public function hasLabels()
    {
        return $this->labels->count() > 0;
    }

    /**
     * Determine if the topic is paged
     *
     * @return boolean
     */
    public function isPaged()
    {
        return $this->replies->count() > Config::get('forums::per_page');
    }

    /**
     * Get the mini pagination
     *
     * @return string
     */
    public function getMiniPagination()
    {
        $items = $this->replies;

        $paginator = Paginator::make($items->toArray(), $items->count(), Config::get('forums::per_page'));
        $paginator->setBaseUrl($this->getLink());

        return with(new Presenter($paginator))->render();
    }

    /**
     * Get the formatted status label
     *
     * @return string
     */
    public function getStatusLabel()
    {
        $status = $this->status;

        return View::make('forums::front._partials.status', compact(
            'status'
        ))->render();
    }

    /**
     * Get the topic frontend link
     *
     * @return boolean
     */
    public function getLink()
    {
        return URL::route(get_route_prefix() .'forum.front.topic', array(
            'forum' => $this->forum->slug,
            'topic' => $this->slug,
        ));
    }

    /**
     * Get the topic frontend edit link
     *
     * @return boolean
     */
    public function getEditLink()
    {
        return URL::route(get_route_prefix() .'forum.front.topic.edit', array(
            'forum' => $this->forum->slug,
            'topic' => $this->slug,
        ));
    }

    /**
     * Check if the current user can reply to this topic
     *
     * @return boolean
     */
    public function currentUserCanReply()
    {
        $result = $this->fireModelEvent('canReply');

        if (is_bool($result)) {
            return $result;
        }

        // backup
        return Auth::check()&& $this->forum->status != 'closed';
    }

    /**
     * Check if the current user can edit this topic
     *
     * @return boolean
     */
    public function currentUserCanEdit()
    {
        $result = $this->fireModelEvent('canEdit');

        if (is_bool($result)) {
            return $result;
        }

        return $this->user_id == Auth::user()->id;
    }

    /**
     * Checks if the lead topic should be shown
     *
     * @return boolean
     */
    public function showLead()
    {
        $showAlways = Config::get('forums::always_show_lead');
        $paged      = Input::get('page');

        if($showAlways || !$paged || $paged <= 1) {
            return true;
        }

        return false;
    }

    /**
     * Get the total number of participating users
     *
     * @return int
     */
    public function getVoices()
    {
        $userIds = array_pluck($this->replies->toArray(), 'user_id');
        $userIds[] = $this->user_id;

        return count(array_unique($userIds));
    }

    /**
     * Get the latest reply
     *
     * @return ScubaClick\Forums\Models\Reply
     */
    public function getLatestReply()
    {
        return $this->replies()
            ->orderBy('updated_at', 'desc')
            ->first();
    }

    /**
     * Get the freshness of the topic
     *
     * @return View
     */
    public function getFreshness()
    {
        $post = $this->getLatestReply();

        if(is_null($post)) {
            $post = $this;
        }

        return View::make('forums::front._partials.freshness', compact(
            'post'
        ))->render();
    }

    /**
     * Check if the topic has been edited
     *
     * @return boolean
     */
    public function wasEdited()
    {
        if(is_null($this->edited_at)) {
            return false;
        }

        return true;
    }

    /**
     * Get all date columns
     *
     * @return boolean
     */
    public function getDates()
    {
        return array(
            'created_at',
            'updated_at',
            'deleted_at',
            'edited_at',
        );
    }

    /**
     * {@inherit}
     */
    public function getFeedItem()
    {
        return array(
            'title'       => $this->title,
            'author'      => $this->user->getFullName(),
            'link'        => $this->getLink(),
            'pubDate'     => $this->created_at,
            'description' => $this->content,
        );
    }
}
