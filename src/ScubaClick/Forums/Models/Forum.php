<?php namespace ScubaClick\Forums\Models;

use URL;
use Auth;
use View;
use Config;
use Purifier;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Forum extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forums';

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
    	'title',
    	'content',
        'status',
    );

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = array(
        'user_id' => 'required|exists:users,id',
        'title'   => 'required|min:3',
        'content' => 'required|min:8',
        'slug'    => 'required|min:3',
        'status'  => 'required|in:open,closed'
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

            if($model->isDirty('title')) {
                $model->setAttribute('slug', $model->getUniqueSlug($model->getAttribute('title')));
            }

            return $model->validate();
        });
    }

    /**
     * Register a canPost model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function canPost($callback)
    {
        static::registerModelEvent('canPost', $callback);
    }

    /**
     * Get a forum by its slug
     *
     * @param  string $slug
     * @return string
     */
    public static function findBySlug($slug)
    {
        $forum = static::with('topics.replies')
            ->where('slug', $slug)
            ->first();

        if(is_null($forum)) {
            throw new ModelNotFoundException;
        }

        return $forum;
    }

    /**
     * Connect the topics
     *
     * @return object
     */
    public function topics()
    {
        return $this->hasMany('\\ScubaClick\\Forums\\Models\\Topic');
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
     * Get the forum frontend link
     *
     * @return boolean
     */
    public function getLink()
    {
        return URL::route($this->getRoutePrefix() .'forum.front.forum', array(
            'forum' => $this->slug,
        ));
    }

    /**
     * Get the total replies for a topic
     *
     * @return int
     */
    public function getReplyCount()
    {
        $count = 0;

        foreach($this->topics as $topic) {
            $count += $topic->replies->count();
        }

        return $count;
    }

    /**
     * Get the latest topic
     *
     * @return ScubaClick\Forums\Models\Topic
     */
    public function getLatestTopic()
    {
        return $this->topics()
            ->orderBy('updated_at', 'desc')
            ->first();
    }

    /**
     * Check if the current user can post to this forum
     *
     * @return boolean
     */
    public function currentUserCanPost()
    {
        $result = $this->fireModelEvent('canPost');

        if (is_bool($result)) {
            return $result;
        }

        // backup
        return Auth::check() && $this->status != 'closed';
    }
    /**
     * Get the freshness of the forum
     *
     * @return int
     */
    public function getFreshness()
    {
        $post = $this->getLatestTopic();

        return View::make('forums::front._partials.freshness', compact(
            'post'
        ))->render();
    }
}
