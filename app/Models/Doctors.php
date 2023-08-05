<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctors extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'license_no',
        'email',
        'phone',
        'password',
        'specialty_id',
        'degree',
        'experience',
        'consultation_fees',
        'clinic_id',
        'photo'



    ];
}
