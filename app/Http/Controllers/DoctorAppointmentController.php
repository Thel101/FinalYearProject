<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Clinics;
use App\Models\Doctors;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DoctorAppointment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class DoctorAppointmentController extends Controller
{
    //direct to doctor Appointment Page
    public function docAppointmentPage($docId){

        $doctor = Doctors::with('clinics')->find($docId);
        // dd($doctor->toArray());
        $availableClinics=$doctor->clinics->groupBy('id')->map(function($clinic){
            return $clinic->first();
        });
        if ($doctor) {
            $time = $doctor->consultation_duration;
            $clinicSchedules = [];
            $clinics = $doctor->clinics;
            foreach ($clinics as $clinic) {
                $clinicId= $clinic->id;
                $scheduleDay = $clinic->pivot->schedule_day;

                if(!isset($clinicSchedules[$clinicId])){
                    $clinicSchedules[$clinicId]=[];
                }
                $clinicSchedules[$clinicId][] = [
                    'scheduleDay' => $scheduleDay
                ];

            }


        }
        return view('patient.doctorAppointments.doctorAppointment', compact('doctor','time','availableClinics', 'clinicSchedules'));


    }
    //doctor availability
    public function doctorAvailability(Request $request){
        $selectedClinic = $request->clinic;
        $selectedDoctor= $request->doctor;
        $selectedDate=$request->appointmentDate;

        $newFormatDate= new DateTime($selectedDate);

        // logger($newFormatDate->format('Y-m-d'));
        $days= ["Sunday", "Monday","Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];
        $convertedDay= $newFormatDate->format('l');

        $bookedTimeSlot=DoctorAppointment::select('time_slot')
        ->where([
            ['doctor_id',$selectedDoctor],
            ['clinic_id', $selectedClinic],
            ['appointment_date', $newFormatDate]
            ])->get();
        $bookedTimes =[];
        foreach($bookedTimeSlot as $Slot){
            $formattedTimeSlot= Carbon::parse($Slot->time_slot)->format('g:i a');
            $bookedTimes[]= $formattedTimeSlot;

        }

        $doctor = Doctors::with(['clinics' => function ($query) use ($convertedDay) {
            $query->wherePivot('schedule_day', $convertedDay);
        }])->find($selectedDoctor);
        logger($doctor);
        $timeslots = [];

        if ($doctor) {
            $scheduleDay = $doctor->clinics->first()->pivot->schedule_day;
            $startTime = $doctor->clinics->first()->pivot->start_time;
            $endTime = $doctor->clinics->first()->pivot->end_time;
            $newStartTime = Carbon::parse($startTime);
            $newEndTime = Carbon::parse($endTime);
            while($newStartTime->lessThan($newEndTime)){
                $formattedST=$newStartTime->format('g:i a');
                array_push($timeslots, $formattedST);
                $newStartTime->addMinutes(15);
            }

            return response()->json([
                'status'=> 'success',
                'timeslots' => $timeslots,
                'bookedTimes'=> $bookedTimes
            ]);
        }
        else{
            return response()->json([
                'status'=> 'failed'
            ]);
        }


    }

    //book doctor appointment
    public function doctorAppointment(Request $request){
        // dd($request->toArray());
        $type = "doctor";
        $docId= $request->docId;
        $clinicFees= 5000;
        $docFees = Doctors::where('id', $docId)->pluck('consultation_fees')->first();
        $totalFees= $clinicFees + $docFees;
        $time = Carbon::createFromFormat('h:i A', $request->availableTime)->toTimeString();
        $this->validatePatientInfo($request);
        $data = $this->formatAppointmentInfo($request);
        $date = Carbon::parse($data['appointment_date']);
        $formattedDate= $date->format($date);
        $data['time_slot']= $time;
        // dd($time);
        $data['appointment_date']= $formattedDate;
        // dd($data);
        $additionalData =[
            'clinic_charges' => $clinicFees,
            'doctor_fees'=> $docFees,
            'total_fees' => $totalFees,

        ];
        // dd($additionalData);
        $finalData = array_merge($data, $additionalData);
        $doctorAppointmentInfo=DoctorAppointment::create($finalData);
        $appointmentDate= Carbon::parse($doctorAppointmentInfo->appointment_date);
        $date= $appointmentDate->format('Y-m-d');
        // dd($date);
        $clinicInfo= $this->infoClinic($doctorAppointmentInfo->clinic_id);
        $docInfo = Doctors::where('id', $docId)->first();

        // session(['appointmentData' => compact('doctorAppointmentInfo', 'clinicInfo', 'docInfo')]);

        $request->session()->put('doctorAppointmentInfo', $doctorAppointmentInfo);
        $request->session()->put('date', $date);
        $request->session()->put('clinicInfo', $clinicInfo);
        $request->session()->put('docInfo', $docInfo);
        return redirect()->route('doctorAppointment.email');
    }
    public function generatePDF($id){
        $appointmentData= DoctorAppointment::select(
            'doctor_appointments.*',
            'doctors.name as doctor_name',
            'clinics.name as clinic_name',
            'clinics.address as clinic_address',
            'clinics.township as clinic_township',
            'specialties.name as specialty_name',
            'users.name as user_name')
        ->where('doctor_appointments.id', $id)
        ->leftJoin('doctors', 'doctors.id', 'doctor_appointments.doctor_id')
        ->leftJoin('clinics', 'clinics.id', 'doctor_appointments.clinic_id')
        ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
        ->leftJoin('users','users.id', 'doctor_appointments.booking_person')
        ->first();
        // dd($appointmentData->toArray());
        $pdf = PDF::loadView('patient.doctorAppointments.downloadAppointment',compact('appointmentData'));
        return $pdf->stream('appointment_information.pdf');

    }
    ///patient cancel appointments
    public function cancelAppointment(Request $request){
        $appointmentId = $request->input('appointmentID');
        DoctorAppointment::where('id', $appointmentId)->update(['status'=> 'cancelled']);
        return redirect()->route('patient.doctorAppointments')->with(['cancelMessage'=>'Appointment has been cancelled!']);
    }
    //doctor dashboard appointment view

    private function doctorDasbhoard(){
        return Doctors::where('email',Session::get('email'))->first();

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
            'doctor_id' => $request->input('docId'),
            'clinic_id' => $request->input('clinic'),
            'appointment_date' => $request->input('scheduleDate'),
            'time_slot' => $request->input('availableTime'),
            'patient_id' => $request->patientType,
            'booking_person' => $request->input('bookingPerson'),
            'patient_name' => $request->input('patientName'),
            'phone_1' => $request->input('patientPhone'),
            'phone_2' => $request->input('patientPhone2'),
            'patient_age' => $request->input('patientAge'),
            'allergy' => $request->input('allergy'),
            'disease' => $request->input('disease'),
            'symptoms' => $request->input('symptoms')
        ];

        return $appointmentInfo;
        }
        else{
            $appointmentInfo = [
                'doctor_id' => $request->input('docId'),
                'clinic_id' => $request->input('clinic'),
                'appointment_date' => $request->input('scheduleDate'),
                'time_slot' => $request->input('availableTime'),
                'patient_id' => null,
                'booking_person' => $request->input('bookingPerson'),
                'patient_name' => $request->input('nonRegisterPatientName'),
                'phone_1' => $request->input('nonRegisterPatientPhone'),
                'phone_2' => $request->input('nonRegisterPatientPhone2'),
                'patient_age' => $request->input('nonRegisterPatientAge'),
                'allergy' => $request->input('allergy'),
                'disease' => $request->input('disease'),
                'symptoms' => $request->input('symptoms')
            ];

            return $appointmentInfo;
        }

    }
    //validate patient info
    private function validatePatientInfo(Request $request){
        if($request->has('patientId')){
            $validation = [
                'docId' => 'required',
                'clinic' => 'required',
                'scheduleDate' => 'required',
                'availableTime' => 'required',
                'patientName' => 'required',
                'phone1' => 'required|string', // Treat phone numbers as strings
                'phone2' => 'nullable|string', // Treat phone numbers as strings
                'patientAge' => 'required',

            ];

        } else{
            $validation = [
                'docId' => 'required',
                'clinic' => 'required',
                'scheduleDate' => 'required',
                'availableTime' => 'required',
                'nonRegisterPatientName' => 'required',
                'nonRegisterPatientPhone' => 'required|string', // Treat phone numbers as strings
                'nonRegisterPatientPhone2' => 'nullable|string', // Treat phone numbers as strings
                'nonRegisterPatientAge' => 'required',

            ];
        }

        $validation['allergy']= 'nullable';
        $validation['disease']= 'nullable';
        $validation['symptoms'] = 'required';

        try {
            Validator::make($request->all(), $validation)->validate();
        } catch (ValidationException $e) {
            // Handle validation failure, e.g., redirect back with errors
            return redirect()->back()->withErrors($e->validator->errors());
        }
    }
}
