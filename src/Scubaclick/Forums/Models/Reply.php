<?php namespace ScubaClick\Forums\Models;

use Config;

class Reply extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'replies';

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
    	'content',
    ];

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = [
        'user_id'  => '',
        'topic_id' => '',
        'content'  => '',
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
    public function topic()
    {
        return $this->belongsTo('\\ScubaClick\\Forums\\Models\\Topic');
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
