<?php namespace ScubaClick\Forums\Repositories\Eloquent;

use ScubaClick\Forums\Models\Label;
use ScubaClick\Forums\Contracts\LabelsInterface;

class LabelsRepository implements LabelsInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($perPage = 20)
    {
		return Label::paginate($perPage);
    }

    /**
     * {@inheritdoc}
     */
	public function toJson()
	{
		return json_encode(Label::lists('title'));
	}

    /**
     * {@inheritdoc}
     */
	public function create($input)
	{
        return Label::create($input);
	}

    /**
     * {@inheritdoc}
     */
	public function update($id)
	{
        $label = Label::find($id);
        $label->update(Input::except('_token'));

        return $label;
	}

    /**
     * {@inheritdoc}
     */
	public function delete($id)
	{
        $label = Label::find($id);
        $label->delete();

        return !$label->exists;
	}
}
