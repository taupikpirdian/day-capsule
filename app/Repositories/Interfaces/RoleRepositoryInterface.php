<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface
{
    public function getAll();
    public function findOne($id);
}
