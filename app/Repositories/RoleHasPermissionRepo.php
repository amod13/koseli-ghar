<?php
namespace App\Repositories;

use App\Models\RoleHasPermission;

class RoleHasPermissionRepo
{
    protected $model;
    public function __construct(RoleHasPermission $model)
    {
        $this->model = $model;
    }

    /**
     * Get the model instance.
     *
     * @return \App\Models\RoleHasPermission
     */
    public function getModel()
    {
        return $this->model;
    }


    /**
     * Create a new record in the database.
     *
     * @param array $data
     * @return \App\Models\RoleHasPermission
     */
    public function createRecord($data)
    {
        return $this->model->create($data);
    }
}