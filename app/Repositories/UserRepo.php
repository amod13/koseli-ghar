<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepo
{
    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * Create a new record in the database.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function createRecord($data)
    {
        return $this->model->create($data);
    }

    /**
     * Retrieve all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $data = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->get();

        return $data;
    }


    /**
     * Find a record by ID.
     *
     * @param int $id
     * @return \App\Models\User
     */
    public function editRecord($id)
    {
        return $this->model->find($id);
    }

    /**
     * Update a user record in the database with the provided data.
     *
     * @param int $id The ID of the user to be updated.
     * @param array $data An associative array of data to update the user record with.
     * @return bool True if the update was successful, false otherwise.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user with the given ID is not found.
     */
    public function updateRecord($id, $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * Delete a user record from the database.
     *
     * @param int $id The ID of the user to be deleted.
     * @return bool True if the deletion was successful, false otherwise.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user with the given ID is not found.
     */
    public function deleteRecord($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * Get the user detail by ID.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUserDetailById($id)
    {
        $data = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->where('users.id', $id)
            ->first();

        return $data;
    }

    /**
     * Retrieve user details by ID for checkout purposes.
     *
     * This method fetches user details along with their role and additional user details
     * by performing a left join on the roles and user_details tables.
     *
     * @param int $id The ID of the user whose details are to be retrieved.
     * @return \Illuminate\Database\Eloquent\Model|null The user details including role and additional information, or null if not found.
     */
    public function getUserDetailByIdForCheckout($id)
    {
        $data = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
            ->select('users.*', 'roles.name as role_name','user_details.*')
            ->where('users.id', $id)
            ->first();

        return $data;
    }


    /**
     * Retrieve all users with name or status matching the given search criteria.
     *
     * This method fetches all users and filters them based on the given search criteria.
     * The search criteria can include the following keys:
     * - `keyword`: A keyword to search for in the user name
     * - `status`: The status of the orders to filter by
     *
     * The method returns a collection of users that match the search criteria.
     *
     * @param array $searchCriteria An associative array of search criteria
     * @return \Illuminate\Support\Collection A collection of users that match the search criteria
     */
    public function getAllUserByStatusAndKeyword($searchCriteria)
    {
        $data = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select(
                'users.*',
                'roles.name as role_name'
            )
            ->when(!empty($searchCriteria['keyword']), function ($query) use ($searchCriteria) {
                $query->where(function ($q) use ($searchCriteria) {
                    $q->where('users.name', 'like', '%' . $searchCriteria['keyword'] . '%')
                      ->orWhere('users.email', 'like', '%' . $searchCriteria['keyword'] . '%');
                });
            })
            ->when(isset($searchCriteria['status']) && $searchCriteria['status'] !== '', function ($query) use ($searchCriteria) {
                $query->where('users.status', $searchCriteria['status']);
            })
            ->orderByDesc('users.id')
            ->get();

        return $data;
    }


}
