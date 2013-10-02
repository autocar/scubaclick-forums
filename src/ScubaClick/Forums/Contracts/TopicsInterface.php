<?php namespace ScubaClick\Forums\Contracts;

interface TopicsInterface
{
    /**
     * Get all topics for a listing
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function get();

    /**
     * Get all topics for a search term
     *
     * @param string $term
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function search($term);

    /**
     * Get all topics in a forum
     *
     * @param object $forum
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getForForum($forum);

    /**
     * Get all topics in a forum for a feed
     *
     * @param object $forum
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getForFeed($forum);

    /**
     * Get a topic by slug
     *
     * @param string $slug
     * @param string $forum
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findBySlug($slug, $forum);

    /**
     * Get topics in json format
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getJson($id);

    /**
     * Get all trashed topics
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function trashed();

    /**
     * Finally delete a topic
     *
     * @param int $id
     * @return boolean
     */
	public function forceDelete($id);

    /**
     * Restore a topic from the trash
     *
     * @param int $id
     * @return boolean
     */
	public function restore($id);

    /**
     * Empty the trash
     *
     * @return void
     */
	public function emptyTrash();

    /**
     * Create a topic
     *
     * @param array $input
     * @return Illuminate\Database\Eloquent\Model
     */
	public function create($input);

    /**
     * Find a topic or throw an exception
     * 
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
	public function findOrFail($id);

    /**
     * Update a topic
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
	public function update($id);

    /**
     * Update a topic by slug
     *
     * @param string $slug
     * @param string $forum
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateBySlug($slug, $forum);

    /**
     * Resolve a topic by slug
     *
     * @param string $slug
     * @param string $forum
     * @return Illuminate\Database\Eloquent\Model
     */
    public function resolveBySlug($slug, $forum);

    /**
     * Re-open a topic by slug
     *
     * @param string $slug
     * @param string $forum
     * @return Illuminate\Database\Eloquent\Model
     */
    public function reopenBySlug($slug, $forum);

    /**
     * Delete a topic by slug
     *
     * @param string $slug
     * @param string $forum
     * @return Illuminate\Database\Eloquent\Model
     */
    public function deleteBySlug($slug, $forum);

    /**
     * Soft delete a topic
     *
     * @param int $id
     * @return boolean
     */
	public function delete($id);
}
