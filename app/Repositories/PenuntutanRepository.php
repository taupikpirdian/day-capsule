<?php

namespace App\Repositories;

use App\Models\Penuntutan;
use App\Repositories\Interfaces\PenuntutanRepositoryInterface;

class PenuntutanRepository implements PenuntutanRepositoryInterface
{
    public function query()
    {
        return new Penuntutan();
    }

    public function getAll()
    {
        return $this->query()
            ->select([
                'penuntutans.id',
                'penuntutans.actor_id',
                'penuntutans.uuid',
                'institution_category_parts.name as satuan',
                'actors.uuid as uuid_actor',
                'actors.name',
                'penuntutans.no_spdp',
                'penuntutans.date_spdp',
                'jenis_perkaras.name as jenis_perkara',
                'actors.kasus_posisi',
                'actors.jpu',
                'actors.tahapan',
                'penuntutans.keterangan',
                'penuntutans.status',
                'penuntutans.created_at',
                'penyidikans.date_sp_dik as date_sp_dik', 
            ])
            ->join('actors', 'penuntutans.actor_id', '=', 'actors.id')
            ->join('penyidikans', 'penyidikans.actor_id', '=', 'penuntutans.actor_id')
            ->join('institution_category_parts', 'actors.institution_category_part_id', '=', 'institution_category_parts.id')
            ->join('jenis_perkaras', 'actors.jenis_perkara_id', '=', 'jenis_perkaras.id')
            ->orderBy('penuntutans.created_at', 'desc');
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
            'penuntutans.id',
            'penuntutans.actor_id',
            'penuntutans.uuid',
            'penuntutans.no_spdp',
            'penuntutans.date_spdp',
            'actors.institution_category_part_id',
            'penuntutans.keterangan',
            'penuntutans.status',
            'penuntutans.catatan',
            'actors.uuid as uuid_actor',
            'actors.name',
            'actors.kasus_posisi',
            'actors.jenis_perkara_id',
            'actors.status',
            'actors.asal_perkara',
            'actors.jpu',
            'actors.jenis_perkara_prioritas',
            'penyelidikans.no_sp as no_sp_lid', 
            'penyelidikans.date_sp as date_sp_lid', 
            'penyidikans.no_sp_dik as no_sp_dik', 
            'penyidikans.date_sp_dik as date_sp_dik', 
        ])->join('actors', 'penuntutans.actor_id', '=', 'actors.id')
        ->leftJoin('penyelidikans', 'actors.id', '=', 'penyelidikans.actor_id')
        ->leftJoin('penyidikans', 'actors.id', '=', 'penyidikans.actor_id')
        ->where('penuntutans.uuid', $uuid)
        ->first();
    }

    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    public function update($dto)
    {
        $data = $this->findOne($dto['id']);
        $data->no_spdp = $dto['no_spdp'];
        $data->date_spdp = $dto['date_spdp'];
        $data->keterangan = $dto['keterangan'];
        $data->catatan = $dto['catatan'];
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
        $data->save();

        return $data;
    }

    public function count($satuanId, $status, $dateRange)
    {
        return $this->query()->whereHas('actor', function($q) use ($satuanId){
            $q->where('institution_category_part_id', $satuanId);
        })->whereIn('status', $status)
        ->when($dateRange, function($query) use ($dateRange) {
            return $query->whereBetween('date_spdp', $dateRange);
        })
        ->count();
    }

    public function countTuntutanSesuaiSop($year)
    {
        return $this->query()
            ->whereYear('date_spdp', $year)
            ->whereRaw('DATEDIFF(date_ekspose, created_at) <= 14')
            ->where('status', "SUDAH DISPOSISI")
            ->count();
    }
}
