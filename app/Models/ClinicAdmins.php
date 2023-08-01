<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicAdmins extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone1', 'phone2', 'clinic_id'];
}
