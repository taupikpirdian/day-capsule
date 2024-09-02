<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Eksekusi extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'actor_id',
        'pidana_badan',
        'subsider_pidana_badan',
        'denda',
        'subsider_denda',
        'uang_pengganti',
        'barang_bukti',
        'pelelangan_barang_sitaan',
        'keterangan',
        'catatan',
        'status',
        'pelelangan_benda_sitaan',
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
                if($model->denda != "" && $model->denda != 0){
                    $model->denda = convertCurrencyToInt($model->denda);
                }
                if($model->uang_pengganti != "" && $model->uang_pengganti != 0){
                    $model->uang_pengganti = convertCurrencyToInt($model->uang_pengganti);
                }
            });
            self::updating(function ($model) {
                if($model->denda != "" && $model->denda != 0){
                    $model->denda = convertCurrencyToInt($model->denda);
                }
                if($model->uang_pengganti != "" && $model->uang_pengganti != 0){
                    $model->uang_pengganti = convertCurrencyToInt($model->uang_pengganti);
                }
            });
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

    public function penuntutan()
    {
        return $this->belongsTo('App\Models\Penuntutan', 'actor_id', 'actor_id');
    }

    public function p48()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_P48);
    }

    public function p48a()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_P48A);
    }

    public function d4()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_D4);
    }

    public function sp3()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_SP3)->where('data_type', EKSEKUSI);
    }

    public function pidsus38()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_PIDSUS_38);
    }
}
