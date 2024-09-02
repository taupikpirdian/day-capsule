<?php

namespace App\Repositories;

use App\Models\InstitutionCategoryPart;
use App\Repositories\Interfaces\SatuanKerjaRepositoryInterface;

class SatuanKerjaRepository implements SatuanKerjaRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new InstitutionCategoryPart();
    }

    public function getAll()
    {
        return $this->query()->orderBy('created_at', 'desc')->get();
    }

    public function findOneByPartId($partId)
    {
        return $this->query()->where('id', $partId)->first();
    }
}
