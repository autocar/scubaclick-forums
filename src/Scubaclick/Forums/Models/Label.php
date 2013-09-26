<?php namespace ScubaClick\Forums\Models;

class Label extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'labels';

    /**
     * Defining fillable attributes on the model
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
    ];

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = [
        'title' => '',
        'slug'  => '',
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
        return $this->belongsToMany('\\ScubaClick\\Models\\Forum\\Topics');
    }
}
