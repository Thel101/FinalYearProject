<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Clinics;
use App\Models\Doctors;
use App\Models\Services;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\DoctorAppointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    //home page
    public function home(){
        $services =ServiceCategory::take(3)->get();
        $serviceCount = Services::get();
        $specialties = Specialty::get();
        $doctors = Doctors::select('doctors.*', 'specialties.name as specialty_name')
        ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
        ->take(4)->get();
        $clinics = Clinics::get();
        $patients = User::where('role', 'user')->get();
        // dd($patients);
        return view('patient.home', [
            'services' => $services,
            'serviceCount' => $serviceCount,
            'specialties'=>$specialties,
            'doctors'=>$doctors,
            'patients'=> $patients,
            'clinics'=> $clinics

        ]);
    }
    //clinic Section
    public function clinicDisplay($id){
        $clinic = Clinics::where('id', $id)->get();
        // logger($clinic);
        return response()->json([
            'status'=> 'success',
            'clinicData' => $clinic
        ]);
    }
    //register form
    public function registerPatient(){
        return view('patient.register');
    }
    //register function
    public function patientRegister(Request $request){

        $this->validatePatientInfo($request);
        $data = $this->formatPatientInfo($request);
        User::create($data);
        return redirect()->route('patient.home');
    }
    //patient profile
    public function profile(){
        return view('patient.profile');
    }
    //patient dashboard profile details
    public function profileDetails(){
        return view('patient.profilePage');
    }
    //patient dashboard service appointment list
    public function serviceAppointmentList(){
        return view('patient.serviceAppointmentList');
    }
    //patient dashboard doctor appointment list
    public function doctorAppointmentList(){

        $appointments = DoctorAppointment::select(
            'doctor_appointments.*',
            'doctors.name as doctor_name',
            'clinics.name as clinic_name',
            'clinics.address as clinic_address',
            'clinics.township as clinic_township',
            'specialties.name as specialty_name')
        ->where('booking_person', Auth::user()->id)
        ->leftJoin('doctors', 'doctors.id', 'doctor_appointments.doctor_id')
        ->leftJoin('clinics', 'clinics.id', 'doctor_appointments.clinic_id')
        ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
        ->get();
        return view('patient.doctorAppointmentList', compact('appointments'));
    }
    //patient dashboard medical record list
    public function records(){
        return view('patient.recordList');
    }
    //service List display
    public function serviceDetails($id){
        $service = Services::select('services.*','service_categories.name as category_name')
        ->where('services.category_id', $id)
        ->leftJoin('service_categories', 'service_categories.id', 'services.category_id')
        ->get();
        $currentCategory = null;
        return view('patient.serviceDetail', compact('service', 'currentCategory'));
    }
    //service details with clinic info
    public function serviceClinicDetails($id){
        $serviceInfo = Services::select('services.*', 'clinics.name as clinic_name', 'clinics.address as clinic_address', 'clinics.phone as clinic_phone')
        ->where('services.id', $id)
        ->leftJoin('clinics', 'clinics.id', 'services.clinic_id')
        ->first();
        logger($serviceInfo);
        return response()->json([
            'status' => 'success',
            'service_data' => $serviceInfo
        ]);

    }
    //specific doctor details and doctor of same specialty
    public function doctorDetails($did){

        //specific doctor
        $doctor= Doctors::select('doctors.*', 'specialties.name as specialty_name')
        ->where('doctors.id',$did)
        ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
        ->first();
        //other similar doctors
        $doctor_specialty= $doctor->specialty_id;
        $doctors = Doctors::select('doctors.*')
        ->where('specialty_id', $doctor_specialty)
        ->where('doctors.id','!=', $did)
        ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')->get();
        return view('patient.doctorDetail', compact('doctor', 'doctors'));
    }

    //format patient info
    private function formatPatientInfo(Request $request){
        return[
            'name' =>$request->patientName,
            'email' => $request->patientEmail,
            'phone1' => $request->patientPhone,
            'address' => $request->patientAddress,
            'role' => 'user',
            'password' => Hash::make($request->patientPassword)
        ];

    }
    //validate patient info
    private function validatePatientInfo(Request $request){
        $validate = [
            'patientName' => 'required| min:5',
            'patientEmail' => 'required | unique:users,email',
            'patientPhone' => 'required|numeric',
            'patientAddress'=> 'required|min:5',
            'patientPassword'=> 'required'
        ];
        Validator::make($request->all(), $validate )->validate();

    }
}
