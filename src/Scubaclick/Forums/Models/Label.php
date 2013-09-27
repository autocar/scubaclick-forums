<?php namespace ScubaClick\Forums\Models;

use DB;
use Illuminate\Support\Str;

class Label extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'labels';

    /**
     * No timestamps for meta data
     *
     * @var bool
     */
    public $timestamps = false;

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
        'title' => 'required|min:3',
        'slug'  => 'required|min:3|unique:labels,slug',
	];

   /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            $model->slug = !empty($model->slug) ? Str::slug($model->slug) : Str::slug($model->title);

            return $model->validate();
        });

        static::deleted(function($model)
        {
            DB::table('label_topic')->where('label_id', $model->id)->delete();
        });
    }

    /**
     * Connect the topics
     *
     * @return object
     */
    public function topics()
    {
        return $this->belongsToMany('\\ScubaClick\\Forums\\Models\\Topic');
    }
}
