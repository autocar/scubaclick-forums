<?php namespace ScubaClick\Forums\Contracts;

interface LabelsInterface
{
    /**
     * Get paginated labels
     *
     * @return array
     */
    public function get($perPage = 20);

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
