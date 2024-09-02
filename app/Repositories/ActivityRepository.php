<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Repositories\Interfaces\ActivityRepositoryInterface;

class ActivityRepository implements ActivityRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new Activity();
    }

    public function store($dto)
    {
        return $this->query()->create($dto);
    }

    public function datatable($request)
    {
        return $this->query()::orderBy('created_at', 'desc')->offset($request->start)->limit($request->length);
    }

    public function totalRecords($request)
    {
        return $this->query()::count();
    }

    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();;
    }

    public function getTitles()
    {
        return $this->query()->select([
            'slug',
            'title'
        ])->groupBy('slug', 'title')->get();
    }
}
