<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'photo',
        'category_id',
        'clinic_id',
        'description',
        'components',
        'price',
        'promotion_rate',
        'promotion'
    ];
    protected $casts = [
        'components' => 'array'
    ];
}
