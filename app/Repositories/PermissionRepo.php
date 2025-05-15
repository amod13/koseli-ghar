<?php
namespace App\Repositories;

use App\Models\Permission;

class PermissionRepo
{
    protected $model;
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    /**
     * Get the model instance.
     *
     * @return \App\Models\Role
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Retrieve all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $permissions = $this->model->select('id', 'name', 'group_name', 'action', 'controller')->get();

        // Grouping the data by groupname using Laravel's collection method
        return $permissions->groupBy('group_name');
    }


    /**
     * Create a new record in the database.
     *
     * @param array $data
     * @return \App\Models\Role
     */
    public function createRecord($data)
    {
        return $this->model->create($data);
    }

    /**
     * Find a record by ID.
     *
     * @param int $id
     * @return \App\Models\Role
     */
    public function editRecord($id)
    {
        return $this->model->find($id);
    }

    /**
     * Update a record in the database with the provided data.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateRecord($id, $data)
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Delete a record from the database.
     *
     * @param int $id
     * @return bool
     */
    public function deleteRecord($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * Get all permissions from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPermission()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

}
