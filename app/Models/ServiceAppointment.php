<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAppointment extends Model
{
    use HasFactory;
    protected $fillable=[
        'service_id',
        'clinic_id',
        'fees',
        'discount',
        'total_fees',
        'appointment_date',
        'time_slot',
        'referral_letter',
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
    protected $dates=[
        'appointment_date'
    ];
}
