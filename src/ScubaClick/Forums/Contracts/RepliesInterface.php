<?php namespace ScubaClick\Forums\Contracts;

interface RepliesInterface
{
    /**
     * Get all replies for a listing
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function get();

    /**
     * Get all replies for a topic
     *
     * @param object $topic
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getForTopic($topic);

    /**
     * Get all replies for a topic
     *
     * @param object $topic
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getForFeed($topic);

    /**
     * Get all trashed replies
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function trashed();

    /**
     * Finally delete a reply
     *
     * @param int $id
     * @return boolean
     */
	public function forceDelete($id);

    /**
     * Restore a reply from the trash
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
     * Create a reply
     *
     * @param array $input
     * @return Illuminate\Database\Eloquent\Model
     */
	public function create($input);

    /**
     * Find a reply or throw an exception
     * 
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
	public function findOrFail($id);

    /**
     * Update a reply
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
	public function update($id);

    /**
     * Soft delete a reply
     *
     * @param int $id
     * @return boolean
     */
	public function delete($id);

    /**
     * Update a reply with author check
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateWithCheck($id);

    /**
     * Soft delete a reply with author check
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function deleteWithCheck($id);
}
