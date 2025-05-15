<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\UserRegisteredNotification;
use App\Repositories\RoleRepo;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $view;
    protected $repo, $roleRepo;
    public function __construct(UserRepo $repo, RoleRepo $roleRepo)
    {
        $this->middleware('check.permission');
        $this->view = 'admin.page.user';
        $this->repo = $repo;
        $this->roleRepo = $roleRepo;

    }

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['header_title'] = 'User List';
        $data['users'] = collect([]);


        return view($this->view . '.index', ['data' => $data]);
    }
    /**
     * Display the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['header_title'] = 'Add User';
        $data['roles'] = $this->roleRepo->getAll();
        return view($this->view . '.create', ['data' => $data]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->only($this->repo->getModel()->getFillable());

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $result = $this->repo->createRecord($data);
        if ($result) {
            return redirect()->route('user.index')->with('success', 'User Created Successfully');
        } else {
            return redirect()->route('user.index')->with('error', 'Something went wrong');
        }
    }


    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data['header_title'] = 'Edit User';
        $data['user'] = $this->repo->editRecord($id);
        $data['roles'] = $this->roleRepo->getAll();
        return view($this->view . '.edit', ['data' => $data]);
    }


    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Fetch the user data based on the provided ID
        $data['user'] = $this->repo->editRecord($id);

        // Validate the request data
        $data = $request->only($this->repo->getModel()->getFillable());

        // Check if a new password is provided, and hash it if so
        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            // If no password is provided, remove the password key from the data to avoid overwriting
            unset($data['password']);
        }

        // Update the user record in the database
        $result = $this->repo->updateRecord($id, $data);

        // Check if the update was successful and return the appropriate response
        if ($result) {
            return redirect()->route('user.index')->with('success', 'User Updated Successfully');
        } else {
            return redirect()->route('user.index')->with('error', 'Something went wrong');
        }
    }


    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $result = $this->repo->deleteRecord($id);
        if ($result) {
            return redirect()->route('user.index')->with('success', 'User Deleted Successfully');
        } else {
            return redirect()->route('user.index')->with('error', 'Something went wrong');
        }
    }


    /**
     * Fetches all users from the database based on the given search criteria and renders the list view.
     *
     * This method fetches all users and filters them based on the given search criteria.
     * The search criteria can include the following keys:
     * - `keyword`: A keyword to search for in the user name
     * - `status`: The status of the orders to filter by
     *
     * The method then passes the selected search criteria back to the view for form repopulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function getUserSearchByNameOrStatus(Request $request)
    {
        // Fetch search criteria from the request
        $searchCriteria = [
            'keyword' => $request->input('keyword'),
            'status' => $request->input('status'),
        ];

        // get alll= ordr based on the search criteria
        $data['users'] = $this->repo->getAllUserByStatusAndKeyword($searchCriteria);



        // Pass the selected search criteria back to the view for form repopulation
        $data['selected_keyword'] = $request->input('keyword');
        $data['selected_status'] = $request->input('status');

        return view($this->view . '.index', ['data' => $data]);
    }

}
