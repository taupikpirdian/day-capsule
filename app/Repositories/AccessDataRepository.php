<?php

namespace App\Repositories;

use App\Models\AccessData;
use App\Repositories\Interfaces\AccessDataRepositoryInterface;

class AccessDataRepository implements AccessDataRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new AccessData();
    }

    public function store($dto)
    {
        return $this->query()->create($dto);
    }

    public function delete($actorId)
    {
        $this->query()->where('actor_id', $actorId)->delete();
    }

    public function deleteLimpah($actorId)
    {
        $this->query()->where('actor_id', $actorId)->where('is_limpah', 1)->delete();
    }
}
