<?php namespace ScubaClick\Forums\Models;

use URL;
use Auth;
use Input;
use Config;
use Request;
use Purifier;
use Illuminate\Support\Str;
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
    protected $fillable = [
    	'status',
        'forum_id',
        'priority',
        'type',
    	'title',
    	'content',
    ];

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = [
        'user_id'  => 'required|exists:users,id',
        'forum_id' => 'required|exists:forums,id',
        'priority' => 'required|in:{priorities}',
        'type'     => 'required|in:{types}',
        'status'   => 'required|in:{stati}',
        'title'    => 'required|min:3',
        'content'  => 'required|min:8',
        'slug'     => 'required|min:3',
        'ip'       => 'required|ip',
	];

   /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            $priorities = implode(',', array_keys(Config::get('forums::priorities')));
            $types      = implode(',', array_keys(Config::get('forums::types')));
            $stati      = implode(',', array_keys(Config::get('forums::stati')));

            $rules = array_map(function($rule) use ($priorities, $types, $stati) {
                return str_replace(
                    array('{priorities}', '{types}', '{stati}'), 
                    array($priorities, $types, $stati)
                , $rule);
            }, Topic::$rules);

            $model->user_id = empty($model->user_id) ? Auth::user()->id : $model->user_id;
            $model->content = Purifier::clean($model->content);
            $model->ip      = empty($model->ip) ? Request::getClientIp() : $model->ip;

            if($model->isDirty('title')) {
                $model->setAttribute('slug', $model->getUniqueSlug($model->getAttribute('title')));
            }

            return $model->validate($rules);
        });
    }

    /**
     * Get a topic by its slug
     *
     * @param  string $slug
     * @param  mixed  $forum
     * @return string
     */
    public static function findBySlug($slug, $forum)
    {
        $topic = static::with('replies', 'forum', 'labels')
            ->where('slug', $slug)
            ->remember(5)
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

        return $query->where('title', 'like', "%$search%")
            ->orWhere('content', 'like', "%$search%")
            ->orWhere('priority', 'like', "%$search%")
            ->orWhere('type', 'like', "%$search%")
            ->orWhere('status', 'like', "%$search%");
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
     * Get the formatted priority label
     *
     * @return string
     */
    public function getPriorityLabel()
    {
        return $this->getLabel('priority');
    }

    /**
     * Get the formatted type label
     *
     * @return string
     */
    public function getTypeLabel()
    {
        return $this->getLabel('type');
    }

    /**
     * Get the formatted status label
     *
     * @return string
     */
    public function getStatusLabel()
    {
        return $this->getLabel('status');
    }

    /**
     * Get the formatted label
     *
     * @return string
     */
    protected function getLabel($type)
    {
        if(!$this->getAttribute($type)) {
            return '';
        }

        $labels = Config::get('forums::labels.'. $type);

        if(!isset($labels[$this->$type])) {
            return '';
        }

        return '<span class="label label-'. $labels[$this->$type] .'">'. $this->$type .'</span>';
    }

    /**
     * Can the topic be viewed
     *
     * @return boolean
     */
    public function isViewable()
    {
        return is_null($this->deleted_at);
    }

    /**
     * Get the topic frontend link
     *
     * @return boolean
     */
    public function getLink()
    {
        return URL::to('/'. $this->forum->slug .'/'. $this->slug);
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
     * {@inherit}
     */
    public function getFeedItem()
    {
        return [
            'title'       => $this->title,
            'author'      => $this->user->getFullName(),
            'link'        => $this->getLink(),
            'pubDate'     => $this->created_at,
            'description' => $this->content,
        ];
    }
}
