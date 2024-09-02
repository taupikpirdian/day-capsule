<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Lapdus extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_name',
        'kasus_posisi',
        'status',
        'institution_category_id',
        'institution_category_part_id'
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
                static::addGlobalScope(function (Builder $builder) {
                    $builder->where('institution_category_part_id', dataCategoryPartByAuth());
                });
            }
        }
    }

    public function satuanKerja()
    {
        return $this->belongsTo('App\Models\InstitutionCategoryPart', 'institution_category_part_id', 'id');
    }
}
