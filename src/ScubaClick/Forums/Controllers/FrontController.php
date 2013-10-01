<?php namespace ScubaClick\Forums\Controllers;

use App;
use View;
use Input;
use Config;
use Request;
use Redirect;
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

        $this->feeder = App::make('feeder');

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
    public function topics($forumSlug)
    {
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
     * @param  string $forumSlug 
     * @return Redirect
     */
    public function postTopic($forumSlug)
    {
        $forum  = $this->forums->findBySlug($forumSlug);

        $input = Input::all();
        
        if(!Input::has('status')) {
            $input['status'] = 'open';
        }

        $input['forum_id'] = $forum->id;

        $topic = $this->topics->create($input);

        if ($topic->isSaved()) {
            return Redirect::to($topic->getLink())
                ->with('flash_success', 'Topic has been saved.');

        } else {
            return Redirect::back()
                ->withErrors($topic->getErrors())
                ->withInput();
        }
    }

    /**
     * Display a feed of topics
     *
     * @param  string $forumSlug 
     * @param  string $feed
     * @return Response
     */
    public function topicsFeed($forumSlug, $feed)
    {
        $forum  = $this->forums->findBySlug($forumSlug);
        $topics = $this->topics->getForFeed($forum);

        return $this->feeder
            ->setChannel([
                'title'       => $forum->title,
                'description' => $forum->content,
            ])
            ->setFormat($feed)
            ->setItems($topics)
            ->fetch();
    }

    /**
     * Display a listing of replies for a single topic
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @return void
     */
    public function replies($forumSlug, $topicSlug)
    {
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
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @return Redirect
     */
    public function postReply($forumSlug, $topicSlug)
    {
        $topic = $this->topics->findBySlug($topicSlug, $forumSlug);

        $input = Input::all();
        $input['topic_id'] = $topic->id;

        $reply = $this->replies->create($input);

        if ($reply->isSaved()) {
            return Redirect::to($reply->getLink())
                ->with('flash_success', 'Reply has been saved.');

        } else {
            return Redirect::back()
                ->withErrors($reply->getErrors())
                ->withInput();
        }
    }

    /**
     * Display a feed of replies
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @param  string $feed
     * @return Response
     */
    public function repliesFeed($forumSlug, $topicSlug, $feed)
    {
        $topic   = $this->topics->findBySlug($topicSlug, $forumSlug);
        $replies = $this->replies->getForFeed($topic);

        return $this->feeder
            ->setChannel([
                'title'       => $topic->title,
                'description' => $topic->content,
            ])
            ->setFormat($feed)
            ->setItems($replies)
            ->fetch();
    }

    /**
     * Show the form to edit a topic
     *
     * @param  string $account
     * @param  string $forumSlug 
     * @param  string $topicSlug
     */
    protected function editTopic($forumSlug, $topicSlug)
    {
        $topic = $this->topics->findBySlug($topicSlug, $forumSlug);

        $this->layout->content = View::make(Config::get('forums::templates.edit_topic'), compact(
            'topic'
        ));
    }

    /**
     * Edit a topic
     *
     * @param  string $account
     * @param  string $forumSlug 
     * @param  string $topicSlug
     */
    protected function editTopicAction($forumSlug, $topicSlug)
    {
        $topic = $this->topics->findBySlug($topicSlug, $forumSlug);
    }

    /**
     * Delete a topic
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     */
    protected function deleteTopic($forumSlug, $topicSlug)
    {
        $topic = $this->topics->delete($topicSlug, $forumSlug);
    }

    /**
     * Resolve a topic
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     */
    protected function resolveTopic($forumSlug, $topicSlug)
    {
        $topic = $this->topics->findBySlug($topicSlug, $forumSlug);
    }

    /**
     * Reopen a topic
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     */
    protected function reopenTopic($forumSlug, $topicSlug)
    {
        $topic = $this->topics->findBySlug($topicSlug, $forumSlug);
    }

    /**
     * Show the edit reply form
     *
     * @param  string $account
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @param  int $replyId
     */
    public function editReply($forumSlug, $topicSlug, $replyId)
    {
        $reply = $this->replies->findOrFail($replyId);

        $this->layout->content = View::make(Config::get('forums::templates.edit_reply'), compact(
            'reply'
        ));
    }

    /**
     * Edit a reply
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @param  int $replyId
     */
    public function editReplyAction($forumSlug, $topicSlug, $replyId)
    {
        $reply = $this->replies->update($replyId);
    }

    /**
     * Delete a reply
     *
     * @param  string $account
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @param  int $replyId
     */
    protected function deleteReply($forumSlug, $topicSlug, $replyId)
    {
        $reply = $this->replies->delete($replyId);
    }
}
