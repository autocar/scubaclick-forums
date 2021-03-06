<?php namespace ScubaClick\Forums\Models;

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
    	'slug',
    ];

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = [
        'user_id' => '',
        'title'   => '',
        'content' => '',
        'slug'    => '',
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
     * Connect the topics
     *
     * @return object
     */
    public function topics()
    {
        return $this->hasMany('\\ScubaClick\\Models\\Forum\\Topic');
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
