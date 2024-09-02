<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Penuntutan extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'actor_id',
        'no_spdp',
        'date_spdp',
        'keterangan',
        'catatan',
        'status',
    ];

    public static function boot()
    {
        parent::boot();
        if(Auth::check()){
            if (!Auth::user()->hasRole('admin')) {
                static::addGlobalScope(function (Builder $builder) {
                    $builder->whereHas('actor.accessData', function($q){
                        $q->where('institution_category_part_id', dataCategoryPartByAuth());
                    });
                });
            }
        }
    }

    public function actor()
    {
        return $this->belongsTo('App\Models\Actor', 'actor_id', 'id');
    }

    public function penyelidikan()
    {
        return $this->belongsTo('App\Models\Penyelidikan', 'actor_id', 'actor_id');
    }

    public function penyidikan()
    {
        return $this->belongsTo('App\Models\Penyidikan', 'actor_id', 'actor_id');
    }

    public function suratAuditor()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_SURAT_AUDITOR);
    }

    public function p31()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_P31);
    }

    public function p38()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_P38);
    }

    public function putusan()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_PUTUSAN);
    }

    public function sp3()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_SP3)->where('data_type', TUNTUTAN);
    }
}
