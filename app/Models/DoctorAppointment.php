<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAppointment extends Model
{
    use HasFactory;
    protected $fillable=[
        'doctor_id',
        'clinic_id',
        'appointment_date',
        'time_slot',
        'doctor_fees',
        'clinic_charges',
        'total_fees',
        'symptoms',
        'patient_id',
        'booking_person',
        'patient_name',
        'phone_1',
        'phone_2',
        'patient_age',
        'allergy',
        'disease',
        'token_number'


    ];
}
