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
        'consultation_duration',
        'consultation_duration',
        'photo'
    ];
    public function clinics()
    {
        return $this->belongsToMany(Clinics::class)->withPivot(['schedule_day', 'start_time', 'end_time']);
    }
    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }
}
