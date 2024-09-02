<?php

namespace App\Repositories\Interfaces;

interface PenuntutanRepositoryInterface
{
    public function getAll();
    public function store($dto);
    public function update($dto);
    public function findOne($id);
    public function findOneByUuid($uuid);
    public function delete($id);
    public function findOneByActorId($id);
    public function updateStatus($id, $status);
    public function count($id, $status, $daterange);
    public function countTuntutanSesuaiSop($year);
}
