<?php

namespace App\Repositories\Interfaces;

interface LapduRepositoryInterface
{
    public function getAll();
    public function store($dto);
    public function updateStatus($id, $status);
    public function findOne($dto);
    public function delete($id);
    public function count($satuanId, $status, $daterange);
}
