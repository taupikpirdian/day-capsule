<?php

namespace App\Repositories\Interfaces;

interface PenyelidikanRepositoryInterface
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
    public function countPenyelidikanTerkait7Perkara($year, $jenisPerkara);
    public function countByYear($year);
    public function countIsDisposisi($year, $isDisposisi);
    public function countPengembalianUangNegara($year, $nominal);
    public function countSesuaiSop($year);
    public function countCmsP2Count($year);
}
