<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Penyelidikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'actor_id',
        'no_sp',
        'date_sp',
        'keterangan',
        'catatan',
        'status',
        'pnbp',
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
                if($model->pnbp != "" && $model->pnbp != 0){
                    $model->pnbp = convertCurrencyToInt($model->pnbp);
                }
            });
            self::updating(function ($model) {
                if($model->pnbp != "" && $model->pnbp != 0){
                    $model->pnbp = convertCurrencyToInt($model->pnbp);
                }
            });
        }
    }

    public function actor()
    {
        return $this->belongsTo('App\Models\Actor', 'actor_id', 'id');
    }

    public function fileP2()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_P2);
    }

    public function fileCaptureCmsP2()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_CAPTURE_CMS_P2);
    }

    public function sp3()
    {
        return $this->belongsTo('App\Models\FileStorage', 'uuid', 'data_uuid')->where('file_type', FILE_SP3)->where('data_type', PENYIDIKAN);
    }
}
