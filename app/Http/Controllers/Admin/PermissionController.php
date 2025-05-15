<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepo;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $view;
    protected $repo;
    public function __construct(PermissionRepo $repo)
    {
        $this->middleware('check.permission');
        $this->repo = $repo;
        $this->view = 'admin.page.permission';
    }

    /**
     * Show the list of permissions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['header_title'] = 'Permission List';
        $data['permissions'] = $this->repo->getAllPermission();

        return view($this->view . '.index', ['data' => $data]);
    }

    /**
     * Display the form for creating a new permission.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['header_title'] = 'Add Permission';
        return view($this->view . '.create', ['data' => $data]);
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->only($this->repo->getModel()->getFillable());
        $result = $this->repo->createRecord($data);
        if ($result) {
            return redirect()->route('permission.index')->with('success', 'Permission Created Successfully');
        } else {
            return redirect()->route('permission.index')->with('error', 'Something went wrong');
        }
    }


    /**
     * Display the form for editing the specified permission.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data['header_title'] = 'Edit Permission';
        $data['permission'] = $this->repo->editRecord($id);
        return view($this->view . '.edit', ['data' => $data]);
    }

    /**
     * Update the specified permission in storage.
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
            return redirect()->route('permission.index')->with('success', 'Permission Updated Successfully');
        } else {
            return redirect()->route('permission.index')->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $result = $this->repo->deleteRecord($id);
        if ($result) {
            return redirect()->route('permission.index')->with('success', 'Permission Deleted Successfully');
        } else {
            return redirect()->route('permission.index')->with('error', 'Something went wrong');
        }
    }
}
