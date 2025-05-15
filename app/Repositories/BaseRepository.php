<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Retrieve a record by ID.
     *
     * @param int $id
     * @return Model|null
     */
    public function editRecord($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create a new record.
     *
     * @param array $data
     * @return Model
     */
    public function createRecord(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a record by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateRecord($id, array $data)
    {
        $record = $this->editRecord($id);
        return $record ? $record->update($data) : false;
    }

    /**
     * Delete a record by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteRecord($id)
    {
        $record = $this->editRecord($id);
        return $record ? $record->delete() : false;
    }

    /**
     * Get the model instance.
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }
}
