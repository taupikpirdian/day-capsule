<?php

namespace App\Repositories\Interfaces;

interface AccessDataRepositoryInterface
{
    public function store($dto);
    public function delete($actorId);
    public function deleteLimpah($actorId);
}
