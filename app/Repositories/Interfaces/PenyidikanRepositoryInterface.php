<?php

namespace App\Repositories\Interfaces;

interface PenyidikanRepositoryInterface
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
    public function countTerkait7Perkara($date, $type);
    public function countPelakuSebagaiPenyelenggaraNegara($year, $isTrue = true);
    public function countPenyidikanDisertaiTPPU($year);
    public function countPenyidikanBerdasarkanKerugian($year, $is5M = true);
    public function countByYear($year);
    public function countIsDisposisi($year, $isDisposisi);
    public function countPenyidikanKorperasi($year);
    public function countPenyidikanPembuktianKerugianNegara($year);
    public function countTapTersangkaCount($year);
    public function countP16($year);
    public function countPenyelematanKerugianNegara($year, $nominal);
    public function countSesuaiSop($year);
    public function countCmsP8Count($year);
}
