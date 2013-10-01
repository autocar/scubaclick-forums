<?php namespace ScubaClick\Forums\Contracts;

interface LabelsInterface
{
    /**
     * Get paginated labels
     *
     * @param int $perPage
     * @return array
     */
    public function get($perPage = 20);

    /**
     * Get a label by its slug
     *
     * @param string $slug
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findBySlug($slug);

    /**
     * Get topics for a label
     *
     * @param object $label
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getTopics($label);

    /**
     * Get topics for a label feed
     *
     * @param object $label
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getTopicFeed($label);

    /**
     * Get all label titles as a json array
     *
     * Useful for use with select2 or chosen
     *
     * @return string
     */
    public function toJson();

    /**
     * Create a label
     *
     * @param array $input
     * @return Illuminate\Database\Eloquent\Model
     */
	public function create($input);

    /**
     * Update a label
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
	public function update($id);

    /**
     * Delete a label
     *
     * @param int $id
     * @return boolean
     */
	public function delete($id);}
