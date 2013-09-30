<?php namespace ScubaClick\Forums\Controllers;

use View;
use Config;
use Request;
use BaseController;
use ScubaClick\Forums\Contracts\TopicsInterface;
use ScubaClick\Forums\Contracts\ForumsInterface;
use ScubaClick\Forums\Contracts\RepliesInterface;

class FrontController extends BaseController
{
    /**
     * Main layout template
     *
     * @var string
     */
    protected $layout = '';

    /**
     * Set everything up
     *
     * @return void
     */
    public function __construct(ForumsInterface $forums, TopicsInterface $topics, RepliesInterface $replies)
    {
        $this->forums  = $forums;
        $this->topics  = $topics;
        $this->replies = $replies;

        $this->layout = Config::get('forums::templates.layout');

        parent::__construct();
    }

    /**
     * Display a listing of forums
     *
     * @return void
     */
    public function forums()
    {
        $forums = $this->forums->get();

        $this->layout->content = View::make(Config::get('forums::templates.forums'), compact(
            'forums'
        ));
    }

    /**
     * Display a listing of topics for a single forum
     *
     * @param  string $forumSlug
     * @return void
     */
    public function topics()
    {
        $args = func_get_args();

        $forumSlug = $this->hasSubdomain($args, 1) ? $args[1] : $args[0];

        $forum  = $this->forums->findBySlug($forumSlug);
        $topics = $this->topics->getForForum($forum);

        $this->layout->content = View::make(Config::get('forums::templates.topics'), compact(
            'topics',
            'forum'
        ));
    }

    /**
     * Post a new topic to a forum
     *
     * @param  string $account
     * @param  string $forumSlug 
     * @return void
     */
    public function postTopic()
    {
        $args = func_get_args();

        $forumSlug = $this->hasSubdomain($args, 1) ? $args[1] : $args[0];

    }

    /**
     * Display a feed of topics
     *
     * @param  string $account
     * @param  string $forumSlug 
     * @param  string $feed
     * @return Response
     */
    public function topicsFeed()
    {
        $args         = func_get_args();
        $hasSubdomain = $this->hasSubdomain($args, 2);

        $forumSlug = $hasSubdomain ? $args[1] : $args[0];
        $feed      = $hasSubdomain ? $args[2] : $args[1];

    }

    /**
     * Display a listing of replies for a single topic
     *
     * @param  string $account
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @return void
     */
    public function replies()
    {
        $args         = func_get_args();
        $hasSubdomain = $this->hasSubdomain($args, 2);

        $forumSlug = $hasSubdomain ? $args[1] : $args[0];
        $topicSlug = $hasSubdomain ? $args[2] : $args[1];

        $topic   = $this->topics->findBySlug($topicSlug, $forumSlug);
        $replies = $this->replies->getForTopic($topic);

        $this->layout->content = View::make(Config::get('forums::templates.replies'), compact(
            'topic',
            'replies'
        ));
    }

    /**
     * Post a new reply to a topic
     *
     * @param  string $account
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @return Response
     */
    public function postReply()
    {
        $args         = func_get_args();
        $hasSubdomain = $this->hasSubdomain($args, 2);

        $forumSlug = $hasSubdomain ? $args[1] : $args[0];
        $topicSlug = $hasSubdomain ? $args[2] : $args[1];

    }

    /**
     * Display a feed of replies
     *
     * @param  string $account
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @param  string $feed
     * @return Response
     */
    public function repliesFeed()
    {
        $args         = func_get_args();
        $hasSubdomain = $this->hasSubdomain($args, 3);

        $forumSlug = $hasSubdomain ? $args[1] : $args[0];
        $topicSlug = $hasSubdomain ? $args[2] : $args[1];
        $feed      = $hasSubdomain ? $args[3] : $args[2];

    }

    /**
     * Check if a subdomain argument has been passed in
     *
     * @param  array $args
     * @param  int $compare 
     * @return boolean
     */
    protected function hasSubdomain($args, $compare)
    {
        return (count($args) - (int) $compare) == 1;
    }
}
