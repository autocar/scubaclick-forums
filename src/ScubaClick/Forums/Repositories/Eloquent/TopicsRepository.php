<?php namespace ScubaClick\Forums\Repositories\Eloquent;

use Auth;
use Input;
use Config;
use ScubaClick\Forums\Models\Topic;
use ScubaClick\Forums\Contracts\TopicsInterface;
use ScubaClick\Forums\Exceptions\NotAllowedException;

class TopicsRepository implements TopicsInterface
{
    /**
     * {@inherit}
     */
	public function get()
	{
        return Topic::with('replies','labels')
            ->orderBy('updated_at', 'desc')
            ->paginate(Config::get('forums::per_page'));
	}

    /**
     * {@inherit}
     */
    public function search($term)
    {
        return Topic::search($term)
            ->orderBy('updated_at', 'desc')
            ->paginate(Config::get('forums::per_page'));
    }

    /**
     * {@inherit}
     */
    public function getForForum($forum)
    {
        return $forum->topics()
            ->orderBy('updated_at', 'desc')
            ->paginate(Config::get('forums::per_page'));
    }

    /**
     * {@inherit}
     */
    public function getForFeed($forum)
    {
        return $forum->topics()
            ->take(Config::get('forums::per_page'))
            ->get();
    }

    /**
     * {@inherit}
     */
    public function findBySlug($slug, $forum)
    {
        return Topic::findBySlug($slug, $forum);
    }

    /**
     * {@inherit}
     */
    public function getJson($id)
    {
        $collection = array();

        if($id) {
            $t = Topic::find($id);
            $topics = [$t];
        } else {
            $search = Input::get('q');
            $limit  = Input::get('limit');
           
            $topics = Topic::search($search)
                ->take($limit)
                ->get();
        }

        foreach($topics as $topic) {
            $collection[] = [
                'id'   => $topic->id,
                'name' => $topic->title,
            ];
        }

        return $id ? $collection[0] : $collection;
    }

    /**
     * {@inherit}
     */
	public function trashed()
	{
        return Topic::onlyTrashed()
            ->paginate(Config::get('forums::per_page'));
	}

    /**
     * {@inherit}
     */
	public function forceDelete($id)
	{
        $topic = Topic::withTrashed()
            ->where('id', $id)
            ->first();

        $topic->forceDelete();

        return !$topic->exists;
	}

    /**
     * {@inherit}
     */
	public function restore($id)
	{
        $topic = Topic::withTrashed()
            ->where('id', $id)
            ->first();

        $topic->restore();
        
        return $topic->isSaved() ? true : $topic->getErrors();
	}

    /**
     * {@inherit}
     */
	public function emptyTrash()
	{
        return Topic::onlyTrashed()
            ->forceDelete();
	}

    /**
     * {@inherit}
     */
	public function create($input)
	{
        $topic = Topic::create($input);

        if($topic->isSaved()) {
            $topic->attachLabels($input['labels']);
        }

        return $topic;
	}

    /**
     * {@inherit}
     */
	public function findOrFail($id)
	{
        return Topic::findOrFail($id);
	}

    /**
     * {@inherit}
     */
	public function update($id)
	{
        $input = Input::all();

        $topic = Topic::find($id);
        $topic->update($input);
        $topic->attachLabels($input['labels']);

        return $topic;
	}

    /**
     * {@inherit}
     */
    public function updateBySlug($slug, $forum)
    {
        $input = Input::all();

        $topic = Topic::findBySlug($slug, $forum);

        if($topic->user_id != Auth::user()->id) {
            throw new NotAllowedException;
        }

        $topic->update($input);
        $topic->attachLabels($input['labels']);

        return $topic;
    }

    /**
     * {@inherit}
     */
    public function resolveBySlug($slug, $forum)
    {
        $topic = Topic::findBySlug($slug, $forum);

        if($topic->user_id != Auth::user()->id) {
            throw new NotAllowedException;
        }

        $topic->update([
            'status' => 'resolved'
        ]);

        return $topic;
    }

    /**
     * {@inherit}
     */
    public function reopenBySlug($slug, $forum)
    {
        $topic = Topic::findBySlug($slug, $forum);

        if($topic->user_id != Auth::user()->id) {
            throw new NotAllowedException;
        }

        $topic->update([
            'status' => 'open'
        ]);

        return $topic;
    }

    /**
     * {@inherit}
     */
    public function deleteBySlug($slug, $forum)
    {
        $topic = Topic::findBySlug($slug, $forum);

        if($topic->user_id != Auth::user()->id) {
            throw new NotAllowedException;
        }

        $topic->delete();

        return $topic;
    }

    /**
     * {@inherit}
     */
	public function delete($id)
	{
        return Topic::find($id)->delete();
	}
}
