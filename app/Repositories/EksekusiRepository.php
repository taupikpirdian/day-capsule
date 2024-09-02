<?php

namespace App\Repositories;

use App\Models\Eksekusi;
use App\Repositories\Interfaces\EksekusiRepositoryInterface;

class EksekusiRepository implements EksekusiRepositoryInterface
{
    public function query()
    {
        return new Eksekusi();
    }

    public function getAll()
    {
        return $this->query()
            ->select([
                'eksekusis.id',
                'eksekusis.uuid',
                'eksekusis.actor_id',
                'institution_category_parts.name as satuan',
                'actors.uuid as uuid_actor',
                'actors.name',
                'jenis_perkaras.name as jenis_perkara',
                'actors.kasus_posisi',
                'actors.tahapan',
                'actors.asal_perkara',
                'eksekusis.keterangan',
                'eksekusis.status',
                'eksekusis.created_at',
                'eksekusis.pidana_badan',
                'eksekusis.denda',
                'eksekusis.subsider_pidana_badan',
                'eksekusis.subsider_denda',
                'eksekusis.barang_bukti',
                'eksekusis.pelelangan_barang_sitaan',
                'eksekusis.uang_pengganti',
            ])
            ->join('actors', 'eksekusis.actor_id', '=', 'actors.id')
            ->join('institution_category_parts', 'actors.institution_category_part_id', '=', 'institution_category_parts.id')
            ->join('jenis_perkaras', 'actors.jenis_perkara_id', '=', 'jenis_perkaras.id')
            ->orderBy('eksekusis.created_at', 'desc');
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
            'eksekusis.id',
            'eksekusis.actor_id',
            'eksekusis.uuid',
            'actors.institution_category_part_id',
            'eksekusis.catatan',
            'eksekusis.pidana_badan',
            'eksekusis.subsider_pidana_badan',
            'eksekusis.denda',
            'eksekusis.subsider_denda',
            'eksekusis.uang_pengganti',
            'eksekusis.barang_bukti',
            'eksekusis.pelelangan_barang_sitaan',
            'eksekusis.keterangan',
            'actors.jpu',
            'actors.name',
            'actors.kasus_posisi',
            'actors.jenis_perkara_id',
            'actors.status',
            'actors.asal_perkara',
            'actors.jenis_perkara_prioritas',
            'penyelidikans.no_sp as no_sp_lid', 
            'penyelidikans.date_sp as date_sp_lid', 
            'penyidikans.no_sp_dik as no_sp_dik', 
            'penyidikans.date_sp_dik as date_sp_dik', 
            'penuntutans.no_spdp', 
            'penuntutans.date_spdp', 
        ])->join('actors', 'eksekusis.actor_id', '=', 'actors.id')
        ->leftJoin('penyelidikans', 'actors.id', '=', 'penyelidikans.actor_id')
        ->leftJoin('penyidikans', 'actors.id', '=', 'penyidikans.actor_id')
        ->leftJoin('penuntutans', 'actors.id', '=', 'penuntutans.actor_id')
        ->where('eksekusis.uuid', $uuid)
        ->first();
    }

    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    public function update($dto)
    {
        $data = $this->findOne($dto['id']);
        if(isset($dto['pidana_badan'])){
            $data->pidana_badan = $dto['pidana_badan'];
        }
        if(isset($dto['subsider_pidana_badan'])){
            $data->subsider_pidana_badan = $dto['subsider_pidana_badan'];
        }
        if(isset($dto['denda'])){
            $data->denda = $dto['denda'];
        }
        if(isset($dto['subsider_denda'])){
            $data->subsider_denda = $dto['subsider_denda'];
        }
        if(isset($dto['uang_pengganti'])){
            $data->uang_pengganti = $dto['uang_pengganti'];
        }
        if(isset($dto['barang_bukti'])){
            $data->barang_bukti = $dto['barang_bukti'];
        }
        if(isset($dto['pelelangan_barang_sitaan'])){
            $data->pelelangan_barang_sitaan = $dto['pelelangan_barang_sitaan'];
        }
        if(isset($dto['keterangan'])){
            $data->keterangan = $dto['keterangan'];
        }
        if(isset($dto['catatan'])){
            $data->catatan = $dto['catatan'];
        }
        if(isset($dto['status'])){
            $data->status = $dto['status'];
        }
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
            return $query->whereBetween('eksekusis.created_at', $dateRange);
        })
        ->count();
    }

    public function countPelelanganBendaSitaan($year)
    {
        return $this->query()
            ->whereYear('created_at', $year)
            ->where('pelelangan_benda_sitaan', 1)
            ->count();
    }

    
}
