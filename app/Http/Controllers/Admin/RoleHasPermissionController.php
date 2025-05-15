<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Repositories\RoleHasPermissionRepo;
use App\Repositories\RoleRepo;
use Illuminate\Http\Request;

class RoleHasPermissionController extends Controller
{
    private $view;
    protected $repo, $roleRepo;
    public function __construct(RoleHasPermissionRepo $repo, RoleRepo $roleRepo)
    {
        $this->view = 'admin.page.role-permission';
        $this->repo = $repo;
        $this->roleRepo = $roleRepo;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|array',
            'permission_id.*' => 'exists:permissions,id',
        ]);

        // Find the role by ID
        $data['role_id'] = $this->roleRepo->editRecord($validated['role_id']);

        // Sync permissions with the role
        $data['role_id']->permissions()->sync($validated['permission_id']);

        // Redirect back with a success message
        return redirect()->route('role.index')->with('success', 'Permissions successfully assigned to role.');
    }
}
