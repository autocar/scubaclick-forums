<?php namespace ScubaClick\Forums\Models;

use URL;
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
     * Automatically update the parent forum
     *
     * @var array
     */
    protected $touches = array('topic');

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
    protected $fillable = array(
        'user_id',
        'topic_id',
    	'content',
        'ip',
    );

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = array(
        'user_id'  => 'required|exists:users,id',
        'topic_id' => 'required|exists:topics,id',
        'content'  => 'required|min:8',
        'ip'       => 'required|ip',
	);

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
     * Register a canEdit model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function canEdit($callback)
    {
        static::registerModelEvent('canEdit', $callback);
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
     * Check if the current user can edit this topic
     *
     * @return boolean
     */
    public function currentUserCanEdit()
    {
        $result = $this->fireModelEvent('canEdit');

        if (is_bool($result)) {
            return $result;
        }

        // backup
        return $this->user_id == Auth::user()->id;
    }

    /**
     * Get the reply title
     *
     * @return boolean
     */
    public function getTitle()
    {
        return sprintf('Reply to %s', $this->topic->title);
    }

    /**
     * Get the reply frontend link
     *
     * @return string
     */
    public function getLink()
    {
        $perPage = Config::get('forums::per_page');

        // we have more than 1 page
        $paged = '';
        $replies = $this->topic->replies;

        if($replies->count() > $perPage) {
            foreach($replies as $index => $reply) {
                if($reply->id == $this->id) {
                    break;
                }
            }

            $paged = '?page='. ceil(($index + 1) / $perPage);
        }

        return $this->topic->getLink() . $paged .'#reply-'. $this->id;
    }

    /**
     * Get the reply frontend edit link
     *
     * @return string
     */
    public function getEditLink()
    {
        return URL::route(get_route_prefix() .'forum.front.reply.edit', array(
            'forum' => $this->topic->forum->slug,
            'topic' => $this->topic->slug,
            'id'    => $this->id,
        ));
    }

    /**
     * Check if the topic has been edited
     *
     * @return boolean
     */
    public function wasEdited()
    {
        return $this->updated_at->gt($this->created_at);
    }

    /**
     * {@inherit}
     */
    public function getFeedItem()
    {
        return array(
            'title'       => $this->getTitle(),
            'author'      => $this->user->full_name,
            'link'        => $this->getLink(),
            'pubDate'     => $this->created_at,
            'description' => $this->content,
        );
    }
}
