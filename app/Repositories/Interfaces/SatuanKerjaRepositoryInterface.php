<?php

namespace App\Repositories\Interfaces;

interface SatuanKerjaRepositoryInterface
{
    public function getAll();
    public function findOneByPartId($partId);
}
