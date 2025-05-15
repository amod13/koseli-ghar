<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepo;
use App\Repositories\RoleRepo;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $view;
    protected $repo, $permissionRepo;
    public function __construct(RoleRepo $repo, PermissionRepo $permissionRepo)
    {
        $this->middleware('check.permission');
        $this->repo = $repo;
        $this->permissionRepo = $permissionRepo;
        $this->view = 'admin.page.role';
    }

    public function index()
    {
        $data['header_title'] = 'Role List';
        $data['roles'] = $this->repo->getAll();
        return view($this->view . '.index', ['data' => $data]);
    }

    /**
     * Display the form for creating a new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['header_title'] = 'Add Role';
        return view($this->view . '.create', ['data' => $data]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only($this->repo->getModel()->getFillable());
        $result = $this->repo->createRecord($data);
        if ($result) {
            return redirect()->route('role.index')->with('success', 'Role Created Successfully');
        } else {
            return redirect()->route('role.index')->with('error', 'Something went wrong');
        }
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data['header_title'] = 'Edit Role';
        $data['role'] = $this->repo->editRecord($id);
        return view($this->view . '.edit', ['data' => $data]);
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->only($this->repo->getModel()->getFillable());
        $result = $this->repo->updateRecord($id, $data);
        if ($result) {
            return redirect()->route('role.index')->with('success', 'Role Updated Successfully');
        } else {
            return redirect()->route('role.index')->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified role from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $result = $this->repo->deleteRecord($id);
        if ($result) {
            return redirect()->route('role.index')->with('success', 'Role Deleted Successfully');
        } else {
            return redirect()->route('role.index')->with('error', 'Something went wrong');
        }
    }


    /**
     * Display the form for adding permissions to a role.
     *
     * @param int $id The role ID
     * @return \Illuminate\View\View
     */
    public function addPermission($id)
    {
        $data['header_title'] = 'Add Permission';
        $data['RoleId'] = $id;
        $data['permissions'] = $this->permissionRepo->getAll();
        $data['getRollName'] = $this->repo->getRollNameByRoleId($id);
        // Get the permission IDs and convert to an array
        $data['roleHasPermissions'] = $this->repo->getRoleHasPermissionByRoleId($id)->toArray();
        return view($this->view . '.add-permission', ['data' => $data]);
    }
}
