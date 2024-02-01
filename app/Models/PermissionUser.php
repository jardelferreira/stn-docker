<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Acl\Models\Permission;

class PermissionUser extends Model
{
    use HasFactory;

    protected $table = "permission_user";

    public function permissionsUser()
    {
        return $this->hasManyThrough(User::class,Permission::class);
    }
}
