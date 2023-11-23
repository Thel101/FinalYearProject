<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorMedicalRecords extends Model
{
    use HasFactory;

    protected $fillable = [
        "appointment_id",
        "current_symptoms",
        "medical_history",
        "family_history",
        "surgery_history",
        "prescription",
        "laboratory_request",
        "referral_letter"];
}
