<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = [
        'name',
    ];

    // Define the many-to-many relationship with Permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permission', 'role_id', 'permission_id');
    }
}