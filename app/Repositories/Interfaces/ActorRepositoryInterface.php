<?php

namespace App\Repositories\Interfaces;

interface ActorRepositoryInterface
{
    public function store($dto);
    public function delete($actorId);
    public function update($dto);
    public function findOneByUuid($uuid);
    public function findOneByUuidWithJoin($uuid);
    public function getAll();
    public function findOne($id);
    public function updateLimpah($id, $limpah);
}
