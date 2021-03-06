<?php namespace ScubaClick\Forums\Repositories\Eloquent;

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
