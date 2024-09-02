<?php

namespace App\Repositories;

use App\Models\Pekerjaan;
use App\Repositories\Interfaces\PekerjaanRepositoryInterface;

class PekerjaanRepository implements PekerjaanRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new Pekerjaan();
    }

    public function getAll()
    {
        return $this->query()->orderBy('name', 'asc')->get();
    }
}
