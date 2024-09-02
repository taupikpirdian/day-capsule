<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'tahapan',
        'jenis_perkara_id',
        'institution_category_id',
        'institution_category_part_id',
        'status',
        'pekerjaan_id',
        'jenis_perkara_prioritas',
        'asal_perkara',
        'kasus_posisi',
        'jpu',
        'keterangan',
        'catatan',
        'limpah',
    ];

    public static function boot()
    {
        parent::boot();
        if(Auth::check()){
            if (!Auth::user()->hasRole('admin')) {
                self::creating(function ($model) {
                    $model->institution_category_id = dataCategoryByAuth();
                    $model->institution_category_part_id = dataCategoryPartByAuth();
                });
            }
        }
    }

    public function penyelidikan()
    {
        return $this->belongsTo('App\Models\Penyelidikan', 'id', 'actor_id');
    }

    public function penyidikan()
    {
        return $this->belongsTo('App\Models\Penyidikan', 'id', 'actor_id');
    }

    public function penuntutan()
    {
        return $this->belongsTo('App\Models\Penuntutan', 'id', 'actor_id');
    }

    public function jenisPerkara()
    {
        return $this->belongsTo('App\Models\JenisPerkara', 'jenis_perkara_id', 'id');
    }

    public function accessData()
    {
        return $this->belongsTo('App\Models\AccessData', 'id', 'actor_id');
    }

    public function accessDataLimpah()
    {
        return $this->belongsTo('App\Models\AccessData', 'id', 'actor_id')->where('is_limpah', 1);
    }
}
