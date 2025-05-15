<?php
namespace App\Repositories;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleRepo
{
    protected $model;
    public function __construct(Role $model)
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
        return $this->model->all();
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
     * Get the name of a role by its id.
     *
     * @param int $id
     * @return string
     */
    public function getRollNameByRoleId($id)
    {
        return $this->model->find($id)->name;
    }

    /**
     * Get the permission IDs for a role.
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function getRoleHasPermissionByRoleId($id)
    {
        $permissions = DB::table('role_has_permission')
            ->where('role_id', $id)
            ->pluck('permission_id'); // Get the permission IDs for the role
        return $permissions;
    }
}