<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinics extends Model
{
    protected $fillable = [
        'name', 'address', 'township', 'phone', 'status', 'opening_hour', 'closing_hour'
    ];
}
