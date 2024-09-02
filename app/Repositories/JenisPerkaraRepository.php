<?php

namespace App\Repositories;

use App\Models\JenisPerkara;
use App\Repositories\Interfaces\JenisPerkaraRepositoryInterface;

class JenisPerkaraRepository implements JenisPerkaraRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new JenisPerkara();
    }

    public function getAll()
    {
        return $this->query()->orderBy('created_at', 'desc')->get();
    }
}
