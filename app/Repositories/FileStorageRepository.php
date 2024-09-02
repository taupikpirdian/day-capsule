<?php

namespace App\Repositories;

use App\Models\FileStorage;
use App\Repositories\Interfaces\FileStorageRepositoryInterface;

class FileStorageRepository implements FileStorageRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new FileStorage();
    }

    public function store($dto)
    {
        return $this->query()->create($dto);
    }

    public function delete($uuidData)
    {
        $this->query()->where('data_uuid', $uuidData)->delete();
    }
}
