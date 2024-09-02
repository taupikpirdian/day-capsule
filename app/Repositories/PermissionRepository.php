<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new Permission();
    }

    public function getAll()
    {
        return $this->query()->orderBy('name', 'asc')->get();
    }

    public function updatePermissionRole($roleId, $permissions)
    {
        $role = Role::where('id', $roleId)->first();
        if($role){
            $role->syncPermissions($permissions);
            return true;
        }
        return false;
    }
}
