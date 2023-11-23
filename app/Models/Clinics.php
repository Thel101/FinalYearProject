<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinics extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'township',
        'phone',
        'photo',
        'status',
        'opening_hour',
        'closing_hour'
    ];
    public function doctors(){
        return $this->belongsToMany(Doctors::class)->withPivot(['schedule_day', 'start_time', 'end_time']);

    }
}
