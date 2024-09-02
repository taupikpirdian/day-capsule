<?php

namespace App\Repositories\Interfaces;

interface ActivityRepositoryInterface
{
    public function store($dto);
    public function datatable($req);
    public function totalRecords($req);
    public function delete($id);
    public function getTitles();
}
