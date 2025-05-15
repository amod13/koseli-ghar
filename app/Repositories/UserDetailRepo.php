<?php
 namespace App\Repositories;

use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;

class UserDetailRepo extends BaseRepository
{
    public function __construct(UserDetail $model)
    {
        parent::__construct($model);

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
            ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
            ->select('users.*', 'roles.name as role_name','user_details.*')
            ->where('users.id', $id)
            ->first();

        return $data;
    }
}
