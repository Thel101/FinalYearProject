<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use Illuminate\Http\Request;
use App\Models\DoctorAppointment;
use App\Models\DoctorMedicalRecords;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DoctorMedicalRecordsController extends Controller
{
    //post medical records
    public function postRecords(Request $request)
    {
        $record = $this->formatMedicalRecords($request);
        $uploadedRecord = DoctorMedicalRecords::create($record);
        $medicalHistory = json_decode($uploadedRecord->medicalHistory);
        $appointmentInfo = DoctorAppointment::where("id", $uploadedRecord->appointment_id)->first();
        if($appointmentInfo){
            $newStatus= 'consulted';
            $appointmentInfo->status= $newStatus;
            $appointmentInfo->save();
        }
        return redirect()->route('doctor.records')->with([
            'success' => 'Medical Record Uploaded',
            'uploadedRecord' => $uploadedRecord,
            'appointmentInfo' => $appointmentInfo,
            'medicalHistory' => $medicalHistory
        ]);
    }
    public function uploadedRecords($id){

        $doctor = $this->doctorDasbhoard();
        $doctorMedicalRecords = DoctorMedicalRecords::select('doctor_medical_records.*', 'doctor_appointments.*')
        ->where('appointment_id',$id)
        ->leftJoin('doctor_appointments','doctor_medical_records.appointment_id','doctor_appointments.id')
        ->first();
        return view('doctor.uploadedMedicalRecords', compact('doctorMedicalRecords','doctor'));
    }
    //doctor profile for Dashboard
    private function doctorDasbhoard()
    {
        return Doctors::where('email', Session::get('email'))->first();
    }
    private function formatMedicalRecords(Request $request)
    {
        $medical= $request->input('medicalHistory',[]);
        return [
            'appointment_id' => $request->input('appointmentID'),
            'current_symptoms' => $request->input('currentSymptoms'),
            'medical_history' => json_encode($medical),
            'family_history' => $request->input('familyHistory'),
            'surgery_history' => $request->input('surgeryHistory'),
            'prescription' => $request->input('prescription'),
            'laboratory_request' => $request->input('laboratory'),
            'referral_letter' => $request->input('referral'),

        ];
    }
}
