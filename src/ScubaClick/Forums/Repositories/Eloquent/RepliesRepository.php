<?php namespace ScubaClick\Forums\Repositories\Eloquent;

use Auth;
use Input;
use ScubaClick\Forums\Models\Reply;
use ScubaClick\Forums\Contracts\RepliesInterface;
use ScubaClick\Forums\Exceptions\NotAllowedException;

class RepliesRepository implements RepliesInterface
{
    /**
     * {@inherit}
     */
	public function get($perPage = 12)
	{
        return Reply::paginate($perPage);
	}

    /**
     * {@inherit}
     */
    public function getForTopic($topic, $perPage = 12)
    {
        return $topic->replies()
            ->paginate($perPage);
    }

    /**
     * {@inherit}
     */
    public function getForFeed($topic, $perPage = 12)
    {
        return $topic->replies()
            ->take($perPage)
            ->get();
    }

    /**
     * {@inherit}
     */
	public function trashed($perPage = 12)
	{
        return Reply::onlyTrashed()
            ->paginate($perPage);
	}

    /**
     * {@inherit}
     */
	public function forceDelete($id)
	{
        $reply = Reply::withTrashed()
            ->where('id', $id)
            ->first();

        $reply->forceDelete();

        return !$reply->exists;
	}

    /**
     * {@inherit}
     */
	public function restore($id)
	{
        $reply = Reply::withTrashed()
            ->where('id', $id)
            ->first();

        $reply->restore();
        
        return $reply->isSaved() ? true : $reply->getErrors();
	}

    /**
     * {@inherit}
     */
	public function emptyTrash()
	{
        return Reply::onlyTrashed()
            ->forceDelete();
	}

    /**
     * {@inherit}
     */
	public function create($input)
	{
        return Reply::create($input);
	}

    /**
     * {@inherit}
     */
	public function findOrFail($id)
	{
        return Reply::findOrFail($id);
	}

    /**
     * {@inherit}
     */
	public function update($id)
	{
        $reply = Reply::find($id);
        $reply->update(Input::all());

        return $reply;
	}

    /**
     * {@inherit}
     */
	public function delete($id)
	{
        return Reply::find($id)->delete();
	}

    /**
     * {@inherit}
     */
    public function updateWithCheck($id)
    {
        $reply = Reply::find($id);

        if($reply->user_id != Auth::user()->id) {
            throw new NotAllowedException;
        }

        $reply->update(Input::all());

        return $reply;
    }

    /**
     * {@inherit}
     */
    public function deleteWithCheck($id)
    {
        $reply = Reply::find($id);

        if($reply->user_id != Auth::user()->id) {
            throw new NotAllowedException;
        }

        $reply->delete();

        return $reply;
    }
}
