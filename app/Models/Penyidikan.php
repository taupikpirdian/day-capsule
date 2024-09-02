<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Penyidikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'actor_id',
        'no_sp_dik',
        'date_sp_dik',
        'nilai_kerugian',
        'disertai_tppu',
        'perkara_pasal_35_ayat_1',
        'keterangan',
        'catatan',
        'status',
        'status',
        'korperasi',
        'penyelamatan_kerugian_negara',
        'kerugian_perekonomian_negara',
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
            self::creating(function ($model) {
                if($model->penyelamatan_kerugian_negara != "" && $model->penyelamatan_kerugian_negara != 0){
                    $model->penyelamatan_kerugian_negara = convertCurrencyToInt($model->penyelamatan_kerugian_negara);
                }
            });
            self::updating(function ($model) {
                if($model->penyelamatan_kerugian_negara != "" && $model->penyelamatan_kerugian_negara != 0){
                    $model->penyelamatan_kerugian_negara = convertCurrencyToInt($model->penyelamatan_kerugian_negara);
                }
            });
        }
    }

    public function actor()
    {
        return $this->belongsTo('App\Models\Actor', 'actor_id', 'id');
    }

    public function pidsus7()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_PIDSUS_7);
    }

    public function p8()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_P8);
    }

    public function fileCaptureCmsP8()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_CAPTURE_CMS_P8);
    }

    public function tapTersangka()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_TAP_TERSANGKA);
    }

    public function p16()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_P16);
    }

    public function p21()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_P21);
    }  

    public function fileBaEkspose()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_BA_EKSPOSE);
    }

    public function sp3()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_SP3)->where('data_type', PENYIDIKAN);
    }
}
