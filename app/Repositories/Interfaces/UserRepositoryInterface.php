<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAll();
    public function store($dto);
    public function delete($id);
    public function findOne($id);
    public function update($dto);
}
