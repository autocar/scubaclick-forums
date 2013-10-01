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
use ScubaClick\Forums\Contracts\LabelsInterface;
use ScubaClick\Forums\Contracts\RepliesInterface;
use ScubaClick\Forums\Exceptions\NotAllowedException;

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
    public function __construct(ForumsInterface $forums, TopicsInterface $topics, RepliesInterface $replies, LabelsInterface $labels)
    {
        $this->forums  = $forums;
        $this->topics  = $topics;
        $this->replies = $replies;
        $this->labels  = $labels;

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

        $labels    = '';
        $allLabels = $this->labels->toJson();

        $this->layout->content = View::make(Config::get('forums::templates.topics'), compact(
            'topics',
            'labels',
            'allLabels',
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
     * @param  string $forumSlug 
     * @param  string $topicSlug
     */
    public function editTopic($forumSlug, $topicSlug)
    {
        $topic = $this->topics->findBySlug($topicSlug, $forumSlug);
        $labels    = implode(',', $topic->labels()->lists('title'));
        $allLabels = $this->labels->toJson();

        $this->layout->content = View::make(Config::get('forums::templates.edit_topic'), compact(
            'topic',
            'labels',
            'allLabels'
        ));
    }

    /**
     * Show the edit reply form
     *
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
     * Display a label archive
     *
     * @param  string $labelSlug
     * @return void
     */
    public function labelArchive($labelSlug)
    {
        $label  = $this->labels->findBySlug($labelSlug);
        $topics = $this->labels->getTopics($label);

        $this->layout->content = View::make(Config::get('forums::templates.labels'), compact(
            'label',
            'topics'
        ));
    }

    /**
     * Display a label archive feed
     *
     * @param  string $labelSlug
     * @param  string $feed
     * @return void
     */
    public function labelArchiveFeed($labelSlug, $feed)
    {
        $label  = $this->labels->findBySlug($labelSlug);
        $topics = $this->labels->getTopicFeed($label);

        return $this->feeder
            ->setChannel([
                'title'       => sprintf('Tag: %s', $label->title),
                'description' => sprintf('All topics tagged with %s', $label->title),
            ])
            ->setFormat($feed)
            ->setItems($topics)
            ->fetch();
    }

    /**
     * Edit a topic
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @return Redirect
     */
    public function editTopicAction($forumSlug, $topicSlug)
    {
        try {
            $topic = $this->topics->updateBySlug($topicSlug, $forumSlug);
        }
        catch(NotAllowedException $exception) {
            return Redirect::to($topic->getLink())
                ->with('flash_error', 'You are not allowed to edit this topic.');
        }

        if($topic->isSaved()) {
            return Redirect::to($topic->getLink())
                ->with('flash_success', 'Topic has been saved.');
        } else {
            return Redirect::back()
                ->withErrors($topic->getErrors())
                ->withInput();
        }
    }

    /**
     * Resolve a topic
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @return Redirect
     */
    public function resolveTopic($forumSlug, $topicSlug)
    {
        try {
            $topic = $this->topics->resolveBySlug($topicSlug, $forumSlug);
        }
        catch(NotAllowedException $exception) {
            return Redirect::to($topic->getLink())
                ->with('flash_error', 'You are not allowed to resolve this topic.');
        }

        if($topic->isSaved()) {
            return Redirect::to($topic->getLink())
                ->with('flash_success', 'Topic has been resolved.');
        } else {
            return Redirect::to($topic->getLink())
                ->with('flash_error', 'Topic could not be resolved.');
        }
    }

    /**
     * Reopen a topic
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @return Redirect
     */
    public function reopenTopic($forumSlug, $topicSlug)
    {
        try {
            $topic = $this->topics->reopenBySlug($topicSlug, $forumSlug);
        }
        catch(NotAllowedException $exception) {
            return Redirect::to($topic->getLink())
                ->with('flash_error', 'You are not allowed to re-open this topic.');
        }

        if($topic->isSaved()) {
            return Redirect::to($topic->getLink())
                ->with('flash_success', 'Topic has been re-opened.');
        } else {
            return Redirect::to($topic->getLink())
                ->with('flash_error', 'Topic could not be re-opened.');
        }
    }

    /**
     * Delete a topic
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @return Redirect
     */
    public function deleteTopic($forumSlug, $topicSlug)
    {
        try {
            $topic = $this->topics->deleteBySlug($topicSlug, $forumSlug);
        }
        catch(NotAllowedException $exception) {
            return Redirect::to($topic->getLink())
                ->with('flash_error', 'You are not allowed to delete this topic.');
        }

        if(!$topic->exists) {
            return Redirect::route($topic->getRoutePrefix() .'forum.front.forum', array(
                    'forum' => $forumSlug
                ))
                ->with('flash_success', 'Topic has been deleted.');
        } else {
            return Redirect::to($topic->getLink())
                ->with('flash_error', 'Topic could not be deleted.');
        }
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
        try {
            $reply = $this->replies->updateWithCheck($replyId);
        }
        catch(NotAllowedException $exception) {
            return Redirect::to($reply->getLink())
                ->with('flash_error', 'You are not allowed to edit this reply.');
        }

        if($reply->isSaved()) {
            return Redirect::to($reply->getLink())
                ->with('flash_success', 'Reply has been updated.');
        } else {
            return Redirect::to($reply->getLink())
                ->with('flash_error', 'Reply could not be updated.');
        }
    }

    /**
     * Delete a reply
     *
     * @param  string $forumSlug 
     * @param  string $topicSlug
     * @param  int $replyId
     */
    public function deleteReply($forumSlug, $topicSlug, $replyId)
    {
        try {
            $reply = $this->replies->deleteWithCheck($replyId);
        }
        catch(NotAllowedException $exception) {
            return Redirect::to($reply->getLink())
                ->with('flash_error', 'You are not allowed to delete this reply.');
        }

        if(!$reply->exists) {
            return Redirect::to($reply->topic->getLink())
                ->with('flash_success', 'Reply has been deleted.');
        } else {
            return Redirect::to($reply->getLink())
                ->with('flash_error', 'Reply could not be deleted.');
        }
    }
}
