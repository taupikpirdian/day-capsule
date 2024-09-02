<?php

namespace App\Repositories\Interfaces;

interface EksekusiRepositoryInterface
{
    public function store($dto);
    public function delete($actorId);
    public function update($dto);
    public function findOneByUuid($uuid);
    public function getAll();
    public function count($id, $status, $daterange);
    public function countPelelanganBendaSitaan($year);
}
