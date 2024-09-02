<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new Role();
    }

    public function getAll()
    {
        return $this->query()->orderBy('name', 'asc')->get();
    }

    public function findOne($id)
    {
        return $this->query()->with('permissions')->where('id', $id)->first();
    }
}
