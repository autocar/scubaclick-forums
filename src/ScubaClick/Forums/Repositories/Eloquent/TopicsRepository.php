<?php namespace ScubaClick\Forums\Repositories\Eloquent;

use Input;
use ScubaClick\Forums\Models\Topic;
use ScubaClick\Forums\Contracts\TopicsInterface;

class TopicsRepository implements TopicsInterface
{
    /**
     * {@inherit}
     */
	public function get($perPage = 12)
	{
        return Topic::with('replies','labels')
            ->paginate($perPage);
	}

    /**
     * {@inherit}
     */
    public function getForForum($forum, $perPage = 12)
    {
        return $forum->topics()
            ->paginate($perPage);
    }

    /**
     * {@inherit}
     */
    public function getForFeed($forum, $perPage = 12)
    {
        return $forum->topics()
            ->take($perPage)
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
	public function trashed($perPage = 12)
	{
        return Topic::onlyTrashed()
            ->paginate($perPage);
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
	public function delete($id)
	{
        return Topic::find($id)->delete();
	}
}
