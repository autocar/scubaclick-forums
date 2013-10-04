<?php namespace ScubaClick\Forums\Models;

use DB;
use URL;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    protected $fillable = array(
        'title',
        'slug',
    );

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = array(
        'title' => 'required|min:3',
        'slug'  => 'required|min:3|unique:labels,slug,{id}',
	);

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
     * Get a label by its slug
     *
     * @param  string $slug
     * @return object
     */
    public static function findBySlug($slug)
    {
        $label = static::with('topics')
            ->where('slug', $slug)
            ->first();

        if(is_null($label)) {
            throw new ModelNotFoundException;
        }

        return $label;
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

    /**
     * Get the link to the label archive
     *
     * @return string
     */
    public function getArchiveLink()
    {
        return URL::route(get_route_prefix() .'forum.front.label.archive', array(
            'label' => $this->slug,
        ));
    }
}
