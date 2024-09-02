<?php

namespace App\Repositories;

use App\Models\Saldo;
use App\Repositories\Interfaces\SaldoRepositoryInterface;

class SaldoRepository implements SaldoRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new Saldo();
    }

    public function findOne()
    {
        return $this->query()->first();
    }

    public function update($dto)
    {
        $data = $this->findOne();
        $data->penyelidikan = $dto['penyelidikan'];
        $data->penyidikan = $dto['penyidikan'];
        $data->penuntutan = $dto['penuntutan'];
        $data->eksekusi = $dto['eksekusi'];
        $data->save();

        return $data;
    }

    public function create($dto)
    { 
        return $this->query()->create($dto);
    }
}
