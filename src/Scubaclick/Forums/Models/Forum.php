<?php namespace ScubaClick\Forums\Models;

use URL;
use Auth;
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
    protected $fillable = [
    	'title',
    	'content',
        'status',
    ];

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = [
        'user_id' => 'required|exists:users,id',
        'title'   => 'required|min:3',
        'content' => 'required|min:8',
        'slug'    => 'required|min:3',
        'status'  => 'required|in:active,closed'
	];

   /**
     * Listen for save event
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
     * Get a forum by its slug
     *
     * @param  string $slug
     * @return string
     */
    public static function findBySlug($slug)
    {
        $forum = static::with('topics.replies')
            ->where('slug', $slug)
            ->remember(5)
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
     * Can the forum be viewed
     *
     * @return boolean
     */
    public function isViewable()
    {
        return $this->status == 'active';
    }

    /**
     * Get the forum frontend link
     *
     * @return boolean
     */
    public function getLink()
    {
        return URL::to('/'. $this->slug);
    }
}
