<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\MedicalResults;
use Illuminate\Http\Request;
use App\Mail\AppointmentConfirm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceAppointmentConfirm;
use Illuminate\Support\Facades\Session;

class MailController extends Controller
{
    public function confirmEmail(Request $request)
    {
        $doctorAppointmentInfo = $request->session()->get('doctorAppointmentInfo');
        $docInfo = $request->session()->get('docInfo');
        $clinicInfo = $request->session()->get('clinicInfo');
        $date = $request->session()->get('date');
        // Mail::to($request->user())->send(new AppointmentConfirm($doctorAppointmentInfo));
        return view('patient.doctorAppointments.doctorAppointmentConfirm', compact('doctorAppointmentInfo', 'clinicInfo', 'docInfo', 'date'))
            ->with('appointmentSuccessMessage', 'Appointment success!Confirmation has been sent to your email.');
    }
    public function confirmServiceAppointmentEmail(Request $request){
        $serviceAppointmentInfo = $request->session()->get('serviceAppointmentInfo');
        $serviceInfo = $request->session()->get('service');
        $clinicInfo = $request->session()->get('clinic');
        $date= $request->session()->get('date');
        // Mail::to($request->user())->send(new ServiceAppointmentConfirm($serviceAppointmentInfo));
        return view('patient.serviceAppointments.appointmentConfirm', compact('serviceAppointmentInfo', 'serviceInfo', 'clinicInfo', 'date'))
            ->with('appointmentSuccessMessage', 'Appointment success!Confirmation has been sent to your email.');
    }
    public function sendResultsEmail(Request $request)
    {
        $records = $request->session()->get('medicalRecord');
        Mail::to(Session::get('email'))->send(new MedicalResults($records));
        $request->session()->forget(['medicalRecord', 'email', 'name','date']);
        $clinic=User::select('users.*', 'clinics.*', 'clinics.name as clinic_name', 'clinics.phone as clinic_phone')
            ->where('users.id', Auth::user()->id)
            ->leftJoin('clinics', 'users.clinic_id', 'clinics.id')->first();

        return redirect()->route('admin.serviceAppointments')->with(['message'=> 'Results successfully sent']);

    }
}
