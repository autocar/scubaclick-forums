<?php namespace ScubaClick\Forums\Models;

use Config;

class Topic extends Model
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
        'priority' => 'required|in:critial,high,normal,low',
        'type'     => 'required|in:bug,enhancement,feature',
        'status'   => 'required|in:new,accepted,progressing,completed,invalid',
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
            return $model->validate();
        });
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
}
