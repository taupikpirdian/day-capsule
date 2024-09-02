<?php

namespace App\Repositories;

use App\Models\Lapdus;
use App\Repositories\Interfaces\LapduRepositoryInterface;

class LapduRepository implements LapduRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new Lapdus();
    }

    public function getAll()
    {
        return $this->query()->select([
            'lapduses.*',
            'institution_category_parts.name as satuan',
        ])->leftJoin('institution_category_parts', 'lapduses.institution_category_part_id', '=', 'institution_category_parts.id')
        ->orderBy('created_at', 'desc');
    }

    public function store($dto)
    {
        return $this->query()->create($dto);
    }

    public function updateStatus($id, $status)
    {
        $data = $this->findOne($id);
        $data->status = $status;
        $data->save();
        
        return $data;
    }

    public function findOne($id)
    {
        return $this->query()->where('id', $id)->first();
    }

    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    public function count($satuanId, $status, $dateRange)
    {
        return $this->query()
        ->where('institution_category_part_id', $satuanId)
        ->where('status', $status)
        ->when($dateRange, function($query) use ($dateRange) {
            return $query->whereBetween('created_at', $dateRange);
        })
        ->count();
    }
}
