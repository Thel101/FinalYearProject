<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function confirmEmail(Request $request){
        $appointmentInfo=$request->session()->get('doctorAppointmentInfo');
        $docInfo = $request->session()->get('docInfo');
        $clinicInfo = $request->session()->get('clinicInfo');

        Mail::to($request->user())->send(new AppointmentConfirm($appointmentInfo));
        $request->session()->forget('doctorAppointmentInfo');
        $request->session()->forget('docInfo');
        $request->session()->forget('clinicInfo');

    }
}
