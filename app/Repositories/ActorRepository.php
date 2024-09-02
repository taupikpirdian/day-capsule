<?php

namespace App\Repositories;

use App\Models\Actor;
use App\Repositories\Interfaces\ActorRepositoryInterface;

class ActorRepository implements ActorRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new Actor();
    }

    public function getAll()
    {
        return $this->query()
            ->select([
                'penyidikans.id',
                'penyidikans.uuid',
                'institution_category_parts.name as satuan',
                'actors.id as id_actor',
                'actors.name',
                'jenis_perkaras.name as jenis_perkara',
                'actors.jenis_perkara_id',
                'actors.tahapan',
                'actors.keterangan',
                'actors.catatan',
                'penyelidikans.uuid as uuid_penyelidikan',
                'penyelidikans.keterangan as ket_penyelidikan',
                'penyidikans.uuid as uuid_penyidikan',
                'penyidikans.keterangan as ket_penyidikan',
                'penuntutans.uuid as uuid_penuntutan',
                'penuntutans.keterangan as ket_penuntutan',
                'eksekusis.uuid as uuid_eksekusi',
                'actors.created_at',
                'actors.updated_at',
            ])
            ->leftjoin('penyelidikans', 'actors.id', '=', 'penyelidikans.actor_id')
            ->leftjoin('penyidikans', 'actors.id', '=', 'penyidikans.actor_id')
            ->leftjoin('penuntutans', 'actors.id', '=', 'penuntutans.actor_id')
            ->leftjoin('eksekusis', 'actors.id', '=', 'eksekusis.actor_id')
            ->join('institution_category_parts', 'actors.institution_category_part_id', '=', 'institution_category_parts.id')
            ->join('jenis_perkaras', 'actors.jenis_perkara_id', '=', 'jenis_perkaras.id')
            ->orderBy('penyidikans.created_at', 'desc');
    }

    public function store($dto)
    {
        return $this->query()->create($dto);
    }

    public function delete($actorId)
    {
        $this->query()->where('id', $actorId)->delete();
    }

    public function findOne($id)
    {
        return $this->query()->where('id', $id)->first();
    }

    public function update($dto)
    {
        $actor = $this->query()->where('id', $dto['id'])->first();
        if(isset($dto['name'])){
            $actor->name = $dto['name'];
        }
        if(isset($dto['tahapan'])){
            $actor->tahapan = $dto['tahapan'];
        }
        if(isset($dto['jenis_perkara_id'])){
            $actor->jenis_perkara_id = $dto['jenis_perkara_id'];
        }
        if(isset($dto['institution_category_id'])){
            $actor->institution_category_id = $dto['institution_category_id'];
        }
        if(isset($dto['institution_category_part_id'])){
            $actor->institution_category_part_id = $dto['institution_category_part_id'];
        }
        if(isset($dto['status'])){
            $actor->status = $dto['status'];
        }
        if(isset($dto['jenis_perkara_prioritas'])){
            $actor->jenis_perkara_prioritas = $dto['jenis_perkara_prioritas'];
        }
        if(isset($dto['asal_perkara'])){
            $actor->asal_perkara = $dto['asal_perkara'];
        }
        if(isset($dto['kasus_posisi'])){
            $actor->kasus_posisi = $dto['kasus_posisi'];
        }
        if(isset($dto['pekerjaan_id'])){
            $actor->pekerjaan_id = $dto['pekerjaan_id'];
        }
        if(isset($dto['jpu'])){
            $actor->jpu = $dto['jpu'];
        }
        if(isset($dto['keterangan'])){
            $actor->keterangan = $dto['keterangan'];
        }
        if(isset($dto['catatan'])){
            $actor->catatan = $dto['catatan'];
        }
        if(isset($dto['limpah'])){
            $actor->limpah = $dto['limpah'];
        }
        $actor->save();

        return $actor;
    }

    public function findOneByUuid($uuid)
    {
        return $this->query()->where('uuid', $uuid)->first();
    }

    public function findOneByUuidWithJoin($uuid)
    {
        return $this->query()->select([
            'actors.id', 
            'actors.name', 
            'actors.status', 
            'actors.institution_category_id', 
            'actors.institution_category_part_id', 
            'actors.asal_perkara', 
            'actors.kasus_posisi', 
            'actors.jenis_perkara_id', 
            'actors.created_at', 
            'actors.jpu', 
            'penyelidikans.no_sp as no_sp_lid', 
            'penyelidikans.date_sp as date_sp_lid', 
            'penyidikans.no_sp_dik as no_sp_dik', 
            'penyidikans.date_sp_dik as date_sp_dik', 
            'penuntutans.no_spdp', 
            'penuntutans.date_spdp', 
        ])->leftJoin('penyelidikans', 'actors.id', '=', 'penyelidikans.actor_id')
        ->leftJoin('penyidikans', 'actors.id', '=', 'penyidikans.actor_id')
        ->leftJoin('penuntutans', 'actors.id', '=', 'penuntutans.actor_id')
        ->where('actors.uuid', $uuid)
        ->first();
    }

    public function updateLimpah($id, $limpah)
    {
        $actor = $this->query()->where('id', $id)->first();
        $actor->limpah = $limpah;
        $actor->save();

        return $actor;
    }
}
