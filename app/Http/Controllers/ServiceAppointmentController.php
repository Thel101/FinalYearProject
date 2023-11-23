<?php

namespace App\Http\Controllers;

use App\Models\ServiceMedicalRecords;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ServiceAppointment;
use Illuminate\Support\Facades\Auth;

class ServiceAppointmentController extends Controller
{
    //clinic service appointment list

    //booked service appointments
    public function bookedAppointments(){

    }
    //send Medical service Results
    public function medicalResultsForm($id)
    {
        $clinic = $this->clinicInfo();
        $serviceAppointment = ServiceAppointment::select('service_appointments.*', 'services.name as service_name')
            ->where('service_appointments.id', $id)
            ->leftJoin('Services', 'services.id', 'service_appointments.service_id')
            ->first();
        $bookingPerson = User::where('id', $serviceAppointment->booking_person)->first();
        return view('admin.services.serviceResultSend', compact('serviceAppointment', 'clinic', 'bookingPerson'));
    }
    //post medical result
    public function sendMedicalResults(Request $request)
    {
        if ($request->hasFile('medical_results')) {
            $email = $request->input('email');
            $patientName = $request->input('patientName');
            $appointment = $request->input('appointmentDate');
            $appointmentID = $request->input('appointmentID');
            $data = $this->formatMedicalResults($request);
            $file = uniqid(). $request->file('medical_results')->getClientOriginalName();
            $request->file('medical_results')->storeAs('public/', $file);
            $data['result_file']=$file;
            $upload_result=ServiceMedicalRecords::create($data);
            $request->session()->put('medicalRecord', $upload_result);
            $request->session()->put('email', $email);
            $request->session()->put('name', $patientName);
            $request->session()->put('date', $appointment);
            ServiceAppointment::where('id', $appointmentID)->update(['status'=> 'recorded']);
            return redirect()->route('admin.resultEmail');
        }
    }
    //cancel appointment from admin dashboard
    public function cancelAppointment(Request $request)
    {
        $appointmentID= $request->input('apptId');
        ServiceAppointment::where('id', $appointmentID)->update(['status'=> 'cancelled']);
        return redirect()->route('admin.bookedServices')->with(['cancel_message'=>'Appointment has been cancelled!']);
    }
    //retrieve clinic info
    private function clinicInfo()
    {
        return User::select('users.*', 'clinics.*', 'clinics.name as clinic_name', 'clinics.phone as clinic_phone')
            ->where('users.id', Auth::user()->id)
            ->leftJoin('clinics', 'users.clinic_id', 'clinics.id')->first();
    }
    private function formatMedicalResults(Request $request)
    {
        return [
            'service_appointment_id' => $request->input('appointmentID'),
            'patient_id' => $request->input('patientID'),
            'patient_name' => $request->input('patientName'),
            'booking_person' => $request->input('bookingPerson'),
        ];
    }
}
