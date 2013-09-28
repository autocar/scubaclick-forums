<?php namespace ScubaClick\Forums\Models;

use Auth;
use Config;
use Request;
use Purifier;
use ScubaClick\Feeder\Contracts\FeedInterface;

class Reply extends Model implements FeedInterface
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
        'user_id',
        'topic_id',
    	'content',
        'ip',
    ];

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = [
        'user_id'  => 'required|exists:users,id',
        'topic_id' => 'required|exists:topics,id',
        'content'  => 'required|min:8',
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
            $model->user_id = empty($model->user_id) ? Auth::user()->id : $model->user_id;
            $model->content = Purifier::clean($model->content);
            $model->ip      = empty($model->ip) ? Request::getClientIp() : $model->ip;

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

    /**
     * Can the reply be viewed
     *
     * @return boolean
     */
    public function isViewable()
    {
        return $this->topic->isViewable();
    }

    /**
     * Get the reply frontend link
     *
     * @return boolean
     */
    public function getLink()
    {
        return $this->topic->getLink() .'#reply-'. $this->id;
    }

    /**
     * {@inherit}
     */
    public function getFeedItem()
    {
        return [
            'title'       => '',
            'author'      => '',
            'link'        => '',
            'pubDate'     => '',
            'description' => '',
        ];
    }
}
