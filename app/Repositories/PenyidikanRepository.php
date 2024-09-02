<?php

namespace App\Repositories;

use App\Models\Penyidikan;
use App\Repositories\Interfaces\PenyidikanRepositoryInterface;

class PenyidikanRepository implements PenyidikanRepositoryInterface
{
    public function query()
    {
        return new Penyidikan();
    }

    public function getAll()
    {
        return $this->query()
            ->select([
                'penyidikans.id',
                'penyidikans.uuid',
                'institution_category_parts.name as satuan',
                'actors.uuid as uuid_actor',
                'actors.name',
                'penyidikans.no_sp_dik',
                'penyidikans.date_sp_dik',
                'jenis_perkaras.name as jenis_perkara',
                'actors.kasus_posisi',
                'actors.tahapan',
                'penyidikans.keterangan',
                'penyidikans.status',
                'penyidikans.created_at',
            ])
            ->with([
                'pidsus7',
                'p8',
            ])
            ->join('actors', 'penyidikans.actor_id', '=', 'actors.id')
            ->join('institution_category_parts', 'actors.institution_category_part_id', '=', 'institution_category_parts.id')
            ->join('jenis_perkaras', 'actors.jenis_perkara_id', '=', 'jenis_perkaras.id')
            ->orderBy('penyidikans.created_at', 'desc');
    }

    public function store($dto)
    {
        return $this->query()->create($dto);
    }

    public function findOne($id)
    {
        return $this->query()->where('id', $id)->first();
    }

    public function findOneByUuid($uuid)
    {
        return $this->query()->select([
            'penyidikans.id',
            'penyidikans.actor_id',
            'penyidikans.uuid',
            'penyidikans.no_sp_dik',
            'penyidikans.date_sp_dik',
            'actors.institution_category_part_id',
            'actors.pekerjaan_id',
            'penyidikans.keterangan',
            'penyidikans.status',
            'penyidikans.catatan',
            'penyidikans.nilai_kerugian',
            'penyidikans.disertai_tppu',
            'penyidikans.korperasi',
            'penyidikans.penyelamatan_kerugian_negara',
            'penyidikans.kerugian_perekonomian_negara',
            'actors.jpu',
            'penyidikans.perkara_pasal_35_ayat_1',
            'actors.name',
            'actors.kasus_posisi',
            'actors.jenis_perkara_id',
            'actors.status',
            'actors.asal_perkara',
            'actors.jenis_perkara_prioritas',
            'actors.limpah',
        ])->join('actors', 'penyidikans.actor_id', '=', 'actors.id')
        ->where('penyidikans.uuid', $uuid)->first();
    }

    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    public function update($dto)
    {
        $data = $this->findOne($dto['id']);
        $data->no_sp_dik = $dto['no_sp_dik'];
        $data->date_sp_dik = $dto['date_sp_dik'];
        $data->keterangan = $dto['keterangan'];
        $data->catatan = $dto['catatan'];
        $data->nilai_kerugian = $dto['nilai_kerugian'];
        $data->disertai_tppu = $dto['disertai_tppu'];
        $data->perkara_pasal_35_ayat_1 = $dto['perkara_pasal_35_ayat_1'];
        $data->korperasi = $dto['korperasi'];
        $data->penyelamatan_kerugian_negara = $dto['penyelamatan_kerugian_negara'];
        $data->kerugian_perekonomian_negara = $dto['kerugian_perekonomian_negara'];
        $data->save();

        return $data;
    }

    public function findOneByActorId($id)
    {
        return $this->query()->where('actor_id', $id)->first();
    }

    public function updateStatus($id, $status)
    {
        $data = $this->findOne($id);
        $data->status = $status;
        $data->save();

        return $data;
    }

    public function count($satuanId, $status, $dateRange)
    {
        return $this->query()->whereHas('actor', function($q) use ($satuanId){
            $q->where('institution_category_part_id', $satuanId);
        })->whereIn('status', $status)
        ->when($dateRange, function($query) use ($dateRange) {
            return $query->whereBetween('date_sp_dik', $dateRange);
        })
        ->count();
    }

    public function countTerkait7Perkara($year, $jenisPerkara)
    {
        return $this->query()
            ->join('actors', 'penyidikans.actor_id', '=', 'actors.id')
            ->where('jenis_perkara_prioritas', $jenisPerkara)
            ->whereYear('date_sp_dik', $year)
            ->count();
    }

    public function countPelakuSebagaiPenyelenggaraNegara($year, $isTrue = true)
    {
        return $this->query()
            ->join('actors', 'penyidikans.actor_id', '=', 'actors.id')
            ->join('pekerjaans', 'pekerjaans.id', '=', 'actors.pekerjaan_id')
            ->when($isTrue, function($query) {
                return $query->where('pekerjaans.name', '!=', "Swasta");
            })
            ->when(!$isTrue, function($query) {
                return $query->where('pekerjaans.name', "Swasta");
            })
            ->whereYear('date_sp_dik', $year)
            ->count();
    }

    public function countPenyidikanDisertaiTPPU($year)
    {
        return $this->query()
            ->join('actors', 'penyidikans.actor_id', '=', 'actors.id')
            ->whereYear('date_sp_dik', $year)
            ->where('disertai_tppu', 1)
            ->count();
    }

    public function countPenyidikanBerdasarkanKerugian($year, $is5M = true)
    {
        return $this->query()
            ->join('actors', 'penyidikans.actor_id', '=', 'actors.id')
            ->whereYear('date_sp_dik', $year)
            ->where('nilai_kerugian', ">5 miliar")
            ->when($is5M, function($query) {
                return $query->where('nilai_kerugian', '=', ">5 miliar");
            })
            ->when(!$is5M, function($query) {
                return $query->where('nilai_kerugian', '!=', ">5 miliar");
            })
            ->count();
    }

    public function countByYear($year)
    {
        return $this->query()
            ->join('actors', 'penyidikans.actor_id', '=', 'actors.id')
            ->whereYear('date_sp_dik', $year)
            ->count();
    }

    public function countIsDisposisi($year, $isDisposisi)
    {
        return $this->query()
            ->whereYear('date_sp_dik', $year)
            ->when($isDisposisi, function($query) {
                return $query->where('status', "SUDAH DISPOSISI");
            })
            ->when(!$isDisposisi, function($query) {
                return $query->where('status', '!=', "SUDAH DISPOSISI");
            })
            ->count();
    }

    public function countPenyidikanKorperasi($year)
    {
        return $this->query()
            ->whereYear('date_sp_dik', $year)
            ->where('korperasi', 1)
            ->count();
    }

    public function countPenyidikanPembuktianKerugianNegara($year)
    {
        return $this->query()
            ->whereYear('date_sp_dik', $year)
            ->where('kerugian_perekonomian_negara', 1)
            ->count();
    }

    public function countTapTersangkaCount($year)
    {
        return $this->query()
            ->join('file_storages', 'penyidikans.uuid', '=', 'file_storages.data_uuid')
            ->whereYear('date_sp_dik', $year)
            ->where('file_storages.data_type', FILE_TAP_TERSANGKA)
            ->count();
    }

    public function countP16($year)
    {
        return $this->query()
            ->join('file_storages', 'penyidikans.uuid', '=', 'file_storages.data_uuid')
            ->when($year, function($query) use($year) {
                return $query->whereYear('date_sp_dik', $year);
            })
            ->where('file_storages.data_type', FILE_P16)
            ->count();
    }

    public function countPenyelematanKerugianNegara($year, $nominal)
    {
        return $this->query()
            ->whereYear('date_sp_dik', $year)
            ->when($nominal == NOMINAL_DIATAS_100M, function($query) {
                return $query->where('penyelamatan_kerugian_negara', '>', NOMINAL_100M);
            })
            ->when($nominal == NOMINAL_KURANG_50M, function($query) {
                return $query->where('penyelamatan_kerugian_negara', '<', NOMINAL_50M);
            })
            ->when($nominal == ANTARA_NOMINAL_50M_DAN_100M, function($query) {
                return $query->where('penyelamatan_kerugian_negara', '>', NOMINAL_50M)->where('penyelamatan_kerugian_negara', '<', NOMINAL_100M);
            })
            ->count();
    }

    public function countSesuaiSop($year)
    {
        return $this->query()
            ->whereYear('date_sp_dik', $year)
            ->whereRaw('DATEDIFF(date_ekspose, created_at) <= 120')
            ->where('status', "SUDAH DISPOSISI")
            ->count();
    }

    public function countCmsP8Count($year)
    {
        return $this->query()
            ->join('file_storages', 'penyidikans.uuid', '=', 'file_storages.data_uuid')
            ->when($year, function($query) use($year) {
                return $query->whereYear('date_sp_dik', $year);
            })
            ->where('file_storages.data_type', FILE_CAPTURE_CMS_P8)
            ->count();
    }
}
