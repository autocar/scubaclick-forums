<?php namespace ScubaClick\Forums\Contracts;

interface TopicsInterface
{
    /**
     * Get all topics for a listing
     *
     * @param int $perPage
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function get($perPage = 12);

    /**
     * Get all trashed topics
     *
     * @param int $perPage
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function trashed($perPage = 12);

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
     * Soft delete a topic
     *
     * @param int $id
     * @return boolean
     */
	public function delete($id);
}
