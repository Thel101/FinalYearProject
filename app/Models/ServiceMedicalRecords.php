<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMedicalRecords extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_appointment_id',
        'patient_id',
        'patient_name',
        'booking_person',
        'result_file'
];
}
