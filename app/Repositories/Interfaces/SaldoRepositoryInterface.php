<?php

namespace App\Repositories\Interfaces;

interface SaldoRepositoryInterface
{
    public function findOne();
    public function update($dto);
    public function create($dto);
}
