<?php namespace ScubaClick\Forums\Models;

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
    	'title',
    	'content',
    	'slug',
    ];

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = [
        'user_id'  => '',
        'forum_id' => '',
        'status'   => '',
        'title'    => '',
        'content'  => '',
        'slug'     => '',
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
        return $this->belongsTo('\\ScubaClick\\Models\\Forum\\Forum');
    }

    /**
     * Connect the replies
     *
     * @return object
     */
    public function replies()
    {
        return $this->hasMany('\\ScubaClick\\Models\\Forum\\Reply');
    }

    /**
     * Connect the labels
     *
     * @return object
     */
    public function labels()
    {
        return $this->belongsToMany('\\ScubaClick\\Models\\Forum\\Label');
    }

    /**
     * Connect the creator
     *
     * @return object
     */
    public function creator()
    {
        return $this->belongsTo('\\ScubaClick\\Models\\Master\\User', 'user_id');
    }
}
