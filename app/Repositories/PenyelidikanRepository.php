<?php

namespace App\Repositories;

use App\Models\Penyelidikan;
use App\Repositories\Interfaces\PenyelidikanRepositoryInterface;

class PenyelidikanRepository implements PenyelidikanRepositoryInterface
{
    public function query()
    {
        return new Penyelidikan();
    }

    public function getAll()
    {
        // TODO, get from access_datas
        return $this->query()
            ->select([
                'penyelidikans.id',
                'penyelidikans.uuid',
                'institution_category_parts.name as satuan',
                'actors.uuid as uuid_actor',
                'actors.name',
                'penyelidikans.no_sp',
                'penyelidikans.date_sp',
                'jenis_perkaras.name as jenis_perkara',
                'actors.kasus_posisi',
                'actors.tahapan',
                'penyelidikans.keterangan',
                'penyelidikans.status',
                'penyelidikans.created_at',
            ])
            ->with([
                'fileP2'
            ])
            ->join('actors', 'penyelidikans.actor_id', '=', 'actors.id')
            ->join('institution_category_parts', 'actors.institution_category_part_id', '=', 'institution_category_parts.id')
            ->join('jenis_perkaras', 'actors.jenis_perkara_id', '=', 'jenis_perkaras.id')
            ->orderBy('penyelidikans.created_at', 'desc');
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
            'penyelidikans.id',
            'penyelidikans.actor_id',
            'penyelidikans.uuid',
            'penyelidikans.no_sp',
            'penyelidikans.date_sp',
            'actors.institution_category_part_id',
            'penyelidikans.keterangan',
            'penyelidikans.status',
            'penyelidikans.catatan',
            'penyelidikans.pnbp',
            'actors.uuid as uuid_actor',
            'actors.name',
            'actors.kasus_posisi',
            'actors.jenis_perkara_id',
            'actors.status',
            'actors.asal_perkara',
            'actors.jenis_perkara_prioritas',
        ])->join('actors', 'penyelidikans.actor_id', '=', 'actors.id')
        ->where('penyelidikans.uuid', $uuid)->first();
    }

    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    public function update($dto)
    {
        $data = $this->findOne($dto['id']);
        $data->no_sp = $dto['no_sp'];
        $data->date_sp = $dto['date_sp'];
        $data->keterangan = $dto['keterangan'];
        $data->catatan = $dto['catatan'];
        $data->pnbp = $dto['pnbp'];
        $data->save();
    }

    public function findOneByActorId($id)
    {
        return $this->query()->where('actor_id', $id)->first();
    }

    public function updateStatus($id, $status)
    {
        $data = $this->findOne($id);
        $data->status = $status;
        $data->date_ekspose = date('Y-m-d');
        $data->save();

        return $data;
    }

    public function count($satuanId, $status, $dateRange)
    {
        return $this->query()->whereHas('actor', function($q) use ($satuanId){
            $q->where('institution_category_part_id', $satuanId);
        })->whereIn('status', $status)
        ->when($dateRange, function($query) use ($dateRange) {
            return $query->whereBetween('date_sp', $dateRange);
        })
        ->count();
    }

    public function countPenyelidikanTerkait7Perkara($year, $jenisPerkara)
    {
        return $this->query()
            ->join('actors', 'penyelidikans.actor_id', '=', 'actors.id')
            ->where('jenis_perkara_prioritas', $jenisPerkara)
            ->whereYear('date_sp', $year)
            ->count();
    }

    public function countByYear($year)
    {
        return $this->query()
            ->whereYear('date_sp', $year)
            ->count();
    }

    public function countIsDisposisi($year, $isDisposisi)
    {
        return $this->query()
            ->whereYear('date_sp', $year)
            ->when($isDisposisi, function($query) {
                return $query->where('status', "SUDAH DISPOSISI");
            })
            ->when(!$isDisposisi, function($query) {
                return $query->where('status', '!=', "SUDAH DISPOSISI");
            })
            ->count();
    }

    public function countPengembalianUangNegara($year, $nominal)
    {
        return $this->query()
            ->whereYear('date_sp', $year)
            ->when($nominal == NOMINAL_KURANG_1M, function($query) {
                return $query->where('pnbp', '<', NOMINAL_KURANG_1M);
            })
            ->when($nominal == NOMINAL_5M, function($query) {
                return $query->where('pnbp', '>', NOMINAL_5M);
            })
            ->when($nominal == ANTARA_NOMINAL_5M_DAN_10M, function($query) {
                return $query->where('pnbp', '>', NOMINAL_5M)->where('pnbp', '<', NOMINAL_10M);
            })
            ->count();
    }

    public function countSesuaiSop($year)
    {
        return $this->query()
            ->whereYear('date_sp', $year)
            ->whereRaw('DATEDIFF(date_ekspose, created_at) <= 60')
            ->where('status', "SUDAH DISPOSISI")
            ->count();
    }

    public function countCmsP2Count($year)
    {
        return $this->query()
            ->join('file_storages', 'penyelidikans.uuid', '=', 'file_storages.data_uuid')
            ->whereYear('date_sp', $year)
            ->where('file_storages.data_type', FILE_CAPTURE_CMS_P2)
            ->count();
    }
}
