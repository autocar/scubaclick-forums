<?php namespace ScubaClick\Forums\Models;

use Config;

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
}
