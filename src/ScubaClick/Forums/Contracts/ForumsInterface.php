<?php namespace ScubaClick\Forums\Contracts;

interface ForumsInterface
{
    /**
     * Get all forums for a listing
     *
     * @param int $perPage
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function get($perPage = 12);

    /**
     * Get a forum by slug
     *
     * @param string $slug
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findBySlug($slug);

    /**
     * Get all trashed forums
     *
     * @param int $perPage
     * @return Illuminate\Database\Eloquent\Collection
     */
	public function trashed($perPage = 12);

    /**
     * Finally delete a forum
     *
     * @param int $id
     * @return boolean
     */
	public function forceDelete($id);

    /**
     * Restore a forum from the trash
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
     * Create a forum
     *
     * @param array $input
     * @return Illuminate\Database\Eloquent\Model
     */
	public function create($input);

    /**
     * Find a forum or throw an exception
     * 
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
	public function findOrFail($id);

    /**
     * Update a forum
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
	public function update($id);

    /**
     * Soft delete a forum
     *
     * @param int $id
     * @return boolean
     */
	public function delete($id);

    /**
     * Get all forums for use in a dropdown
     *
     * @return array
     */
    public function getDropdown();
}
