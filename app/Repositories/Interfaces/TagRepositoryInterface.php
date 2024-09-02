<?php

namespace App\Repositories\Interfaces;

interface TagRepositoryInterface
{
    public function store($dto);
    public function delete($id);
    public function getTag();
}
