<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessData extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_category_id',
        'institution_category_part_id',
        'actor_id',
        'is_limpah',
    ];

    public static function boot()
    {
        parent::boot();
        if(Auth::check()){
            if (!Auth::user()->hasRole('admin')) {
                self::creating(function ($model) {
                    if(!$model->institution_category_part_id){
                        $model->institution_category_id = dataCategoryByAuth();
                        $model->institution_category_part_id = dataCategoryPartByAuth();
                    }
                });
            }
        }
    }
}
