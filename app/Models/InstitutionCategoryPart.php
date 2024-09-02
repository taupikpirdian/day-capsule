<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionCategoryPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_category_id',
        'code',
        'name',
    ];
}
