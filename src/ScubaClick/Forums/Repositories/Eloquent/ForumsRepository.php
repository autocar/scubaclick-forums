<?php namespace ScubaClick\Forums\Repositories\Eloquent;

use Input;
use Config;
use ScubaClick\Forums\Models\Forum;
use ScubaClick\Forums\Contracts\ForumsInterface;

class ForumsRepository implements ForumsInterface
{
    /**
     * {@inherit}
     */
	public function get()
	{
        return Forum::with('topics')
            ->paginate(Config::get('forums::per_page'));
	}

    /**
     * {@inherit}
     */
    public function findBySlug($slug)
    {
        return Forum::findBySlug($slug);
    }

    /**
     * {@inherit}
     */
	public function trashed()
	{
        return Forum::onlyTrashed()
            ->paginate(Config::get('forums::per_page'));
	}

    /**
     * {@inherit}
     */
	public function forceDelete($id)
	{
        $forum = Forum::withTrashed()
            ->where('id', $id)
            ->first();

        $forum->forceDelete();

        return !$forum->exists;
	}

    /**
     * {@inherit}
     */
	public function restore($id)
	{
        $forum = Forum::withTrashed()
            ->where('id', $id)
            ->first();

        $forum->restore();
        
        return $forum->isSaved() ? true : $forum->getErrors();
	}

    /**
     * {@inherit}
     */
	public function emptyTrash()
	{
        return Forum::onlyTrashed()
            ->forceDelete();
	}

    /**
     * {@inherit}
     */
	public function create($input)
	{
        return Forum::create($input);
	}

    /**
     * {@inherit}
     */
	public function findOrFail($id)
	{
        return Forum::findOrFail($id);
	}

    /**
     * {@inherit}
     */
	public function update($id)
	{
        $forum = Forum::find($id);
        $forum->update(Input::all());

        return $forum;
	}

    /**
     * {@inherit}
     */
	public function delete($id)
	{
        return Forum::find($id)->delete();
	}

    /**
     * {@inherit}
     */
    public function getDropdown()
    {
        $forums = Forum::where('status', 'active')->lists('title', 'id');

        return array('' => '') + $forums;
    }
}
