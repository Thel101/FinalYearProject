<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Clinics;
use App\Models\DoctorAppointment;
use App\Models\Doctors;
use App\Models\Services;
use DateTime;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\ServiceAppointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;

class AppointmentController extends Controller
{
    //direct to patient Appointment Page
    public function appointmentPage($id){
        $service = Services::select('services.*', 'clinics.name as clinic_name')
        ->where('services.id', $id)
        ->leftJoin('clinics', 'clinics.id', 'services.clinic_id')
        ->first();
        $todayDate = Carbon::today();
        $dates = [];
        for($i=0; $i<4; $i++){
            $dates []=$todayDate->toFormattedDateString();
            $todayDate->addDay();
        }
        $timeSlots = [
            ['start' => '09:00', 'end' => '12:00', 'label' => 'Morning'],
            ['start' => '13:00', 'end' => '16:00', 'label' => 'Afternoon'],

        ];

        return view('patient.serviceAppointments.appointment', compact('service', 'dates', 'timeSlots'));
    }
    public function services($id){
        $services = Services::select('services.*', 'clinics.name as clinic_name', 'clinics.phone as clinic_phone')
        ->where('category_id', $id)
        ->leftJoin('clinics', 'clinics.id', 'services.clinic_id')
        ->get();
        // logger($services);
        return response()->json([
            'status' => "success",
            'service_data' => $services
        ]);
    }

    //book service appointment
    public function serviceAppointment(Request $request){
        // dd($request);
        $serviceId= $request->serviceId;
        $promoRate= Services::where('id', $serviceId)->pluck('promotion_rate')->first();
        $fees = $request->fees;
        $convertedFees= intval(preg_replace("/[^0-9]/","", $fees));
        $totalFees = $convertedFees + ($convertedFees * $promoRate) / 100;

        $this->validatePatientInfo($request);
        $data = $this->formatAppointmentInfo($request);
        // dd($data);
        if($request->hasFile('referral')){
            $filename = uniqid(). $request->file('referral')->getClientOriginalName();
            $request->file('referral')->storeAs('public/', $filename);
            $data['referral_letter'] = $filename;
        }

        $count= ServiceAppointment::where('service_id', $request->serviceId)
        ->where('appointment_date', $request->appointmentDate)
        ->where('time_slot',$request->appointmentTime)->count();
        $token = $count +1;
        $additionalData =[
            'discount' => $promoRate,
            'fees'=> $convertedFees,
            'total_fees' => $totalFees,
            'token_number' => $token

        ];
        // dd($additionalData);
        $finalData = array_merge($data, $additionalData);
        // dd($finalData);
        $serviceAppointmentInfo=ServiceAppointment::create($finalData);

        // dd('success');
        $appointmentDate= Carbon::parse($serviceAppointmentInfo->appointment_date);
        $date= $appointmentDate->format('Y-m-d');
        // dd($date);
        $clinicInfo= $this->infoClinic($serviceAppointmentInfo->clinic_id);
        // dd($clinicInfo);
        $serviceInfo = Services::where('id', $serviceId)->first();

        $request->session()->put('serviceAppointmentInfo', $serviceAppointmentInfo);
        $request->session()->put('date', $date);
        $request->session()->put('clinicInfo', $clinicInfo);
        $request->session()->put('serviceInfo', $serviceInfo);
        return redirect()->route('serviceAppointment.email');
    }


    //check availablity of timeslot for a data
    public function appointmentDate(Request $request){
      $chosenDate= $request->appointmentDate;
      $service = $request->service;

      $timeSlots= ServiceAppointment::where('appointment_date', $chosenDate)
      ->where('service_id', $service)->pluck('time_slot');
      $timeSlotsCount = $timeSlots->count();
      $availableSlot = Services::where('id', $service)->value('available_token_count');
      $availableSlot = (int) $availableSlot;
      if($timeSlotsCount>$availableSlot){
        return response()->json([
            'status'=> 'success',
            'timeslot'=> $timeSlots,
        ]);
      }
      else{
        return response()->json([
            'status'=> 'fail'
        ]);
      }

    }
    //cancel appointments
    public function cancelAppointment(Request $request){
        $appointmentId = $request->input('appointmentID');
        ServiceAppointment::where('id', $appointmentId)->update(['status'=> 'cancelled']);
        return redirect()->route('patient.serviceAppointments')->with(['cancelMessage'=>'Appointment has been cancelled!']);
    }


    //retrieve service and clinic info
    private function infoService($key){
        $serviceInfo= Services::where('id',$key)->first();
        return $serviceInfo;
    }
    private function infoClinic($clinic){
        $clinicInfo= Clinics::where('id',$clinic)->first();
        return $clinicInfo;
    }
    //format appointment info
    private function formatAppointmentInfo(Request $request){
        $patientType =$request->patientType;
        if($patientType==Auth::user()->id)
      {
        $appointmentInfo = [
            'service_id' => $request->input('serviceId'),
            'clinic_id' => $request->input('clinicId'),
            'appointment_date' => $request->input('appointmentDate'),
            'time_slot' => $request->input('appointmentTime'),
            'referral_letter' => $request->input('referral'),
            'patient_id' => $request->patientType,
            'booking_person' => $request->input('bookingPerson'),
            'patient_name' => $request->input('patientName'),
            'phone_1' => $request->input('patientPhone'),
            'phone_2' => $request->input('patientPhone2'),
            'patient_age' => $request->input('patientAge'),
            'allergy' => $request->input('allergy'),
            'disease' => $request->input('disease'),
        ];

        return $appointmentInfo;
        }
        else{
            $appointmentInfo = [
                'service_id' => $request->input('serviceId'),
                'clinic_id' => $request->input('clinicId'),
                'appointment_date' => $request->input('appointmentDate'),
                'time_slot' => $request->input('appointmentTime'),
                'referral_letter' => $request->input('referral'),
                'patient_id' => null,
                'booking_person' => $request->input('bookingPerson'),
                'patient_name' => $request->input('patientName'),
                'phone_1' => $request->input('patientPhone'),
                'phone_2' => $request->input('patientPhone2'),
                'patient_age' => $request->input('nonRegisterPatientAge'),
                'allergy' => $request->input('allergy'),
                'disease' => $request->input('disease'),
            ];

            return $appointmentInfo;
        }

    }
    //validate patient info
    private function validatePatientInfo(Request $request){
        if($request->has('patientId')){
            $validation = [
                'serviceId' => 'required',
                'clinicId' => 'required',
                'appointmentDate' => 'required',
                'appointmentTime' => 'required',
                'patientName' => 'required',
                'phone1' => 'required|string', // Treat phone numbers as strings
                'phone2' => 'nullable|string', // Treat phone numbers as strings
                'patientAge' => 'required',
                'referral'=> 'required',
                'allergy'=> 'nullable',
                'disease' => 'nullable'
            ];

        } else{
            $validation = [
                'serviceId' => 'required',
                'clinicId' => 'required',
                'appointmentDate' => 'required',
                'appointmentTime' => 'required',
                'nonRegisterPatientName' => 'required',
                'nonRegisterPatientPhone' => 'required|string', // Treat phone numbers as strings
                'nonRegisterPatientPhone2' => 'nullable|string', // Treat phone numbers as strings
                'nonRegisterPatientAge' => 'required',
                'referral'=> 'required',
                'allergy'=> 'nullable',
                'disease' => 'nullable'
            ];
        }
        try
        {
            Validator::make($request->all(), $validation)->validate();
        }
        catch(ValidationException $e){
            return redirect()->back()->withErrors($e->validator->errors());
        }


    }
}
