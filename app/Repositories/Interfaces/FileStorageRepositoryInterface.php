<?php

namespace App\Repositories\Interfaces;

interface FileStorageRepositoryInterface
{
    public function store($dto);
    public function delete($uuid);
}
