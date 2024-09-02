<?php

namespace App\Repositories;

use App\Models\ItemTag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new ItemTag();
    }

    public function store($dto)
    {
        return $this->query()->create($dto);
    }

    public function delete($dataId)
    {
        return $this->query()->where('data_id', $dataId)->delete();;
    }

    public function getTag()
    {
        return $this->query()->select([
            'slug',
            'title'
        ])->groupBy('slug', 'title')->get();
    }
}
