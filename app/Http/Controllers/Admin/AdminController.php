<?php

namespace App\Http\Controllers\Admin;

use session;
use App\Models\User;
use App\Models\Doctors;
use App\Models\Services;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\ServiceAppointment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceMedicalRecords;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Profiler\Profile;

class AdminController extends Controller
{
    //clinic profile
    public function profile()
    {
        $clinic = $this->clinicInfo();
        return view('admin.clinicProfile', compact('clinic'));
    }

    //admin profile
    public function adminProfile()
    {
        $clinic = $this->clinicInfo();
        $admin = User::where('id', Auth::user()->id)->first();
        return view('admin.adminProfile', compact('admin', 'clinic'));
    }



    //service list
    public function serviceList()
    {

        $clinicId = Auth::user()->clinic_id;
        $clinic = $this->clinicInfo();
        $services = Services::select('services.*', 'service_categories.name as category_name')
            ->leftJoin('service_categories', 'service_categories.id', 'services.category_id')
            ->where('services.clinic_id', $clinicId)
            ->get();
        return view('admin.services.serviceList', compact('services', 'clinic'));
    }
    //service register form
    public function registerFormService()
    {
        $clinic = $this->clinicInfo();
        $category = ServiceCategory::get();
        return view('admin.doctors.registerService', compact('clinic', 'category'));
    }
    //register service
    public function registeService(Request $request)
    {
        $data = $this->formatServiceInfo($request);
        $filename = uniqid() . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('public/', $filename);
        $data['photo'] = $filename;
        $data['available_token_count']= "10";
        Services::create($data);
        return redirect()->route('admin.serviceList')->with(['message' => 'Service Registered Successfully']);
    }

    public function serviceAppointments()
    {
        $clinic = $this->clinicInfo();
        $clinicId = Auth::user()->clinic_id;
        $serviceAppointments = ServiceAppointment::select('service_appointments.*', 'services.name as service_name')
            ->where('service_appointments.clinic_id', $clinicId)
            ->where('status', 'booked')
            ->leftJoin('Services', 'services.id', 'service_appointments.service_id')
            ->get();
            $counts=$this->getServiceAppointmentCount($clinicId);
        return view('admin.services.serviceAppointmentTemplate', compact('serviceAppointments', 'clinic','counts'));
    }


    //admin dasbhoard booked service appointments
    public function bookedAppointments()
    {
        $clinic = $this->clinicInfo();
        $clinicId = Auth::user()->clinic_id;
        $appointments = $this->getBookedServiceAppointments($clinicId);
        $counts = $this->getServiceAppointmentCount($clinicId);
        // dd($appointments);
        return view('admin.services.serviceAppointmentList', compact('appointments','clinic','counts'));
    }
    //admin dashboard recorded appointments
    public function recordedAppointments()
    {
        $clinic = $this->clinicInfo();
        $clinicId = Auth::user()->clinic_id;
        $appointments = $this->getRecordedServicAppointments($clinicId);
        $counts = $this->getServiceAppointmentCount($clinicId);
        $records = [];
        foreach($appointments as $appointment){
            $serviceRecordLists= ServiceMedicalRecords::select('service_medical_records.*')
                ->where('service_medical_records.service_appointment_id', $appointment->id)
                ->get();
                $records[$appointment->id] = $serviceRecordLists;
        }
        return view('admin.services.recordedServiceAppointmentList', compact('appointments','clinic','counts','records'));
    }
    //admin dashboard cancelled appointments
    public function cancelledAppointments()
    {
        $clinic = $this->clinicInfo();
        $clinicId = Auth::user()->clinic_id;
        $appointments = $this->getCancelledServicAppointments($clinicId);
        $counts = $this->getServiceAppointmentCount($clinicId);
        return view('admin.services.cancelledServiceAppointment', compact('appointments','clinic','counts'));
    }
    public function missedAppointments(){
        $clinic = $this->clinicInfo();
        $clinicId = Auth::user()->clinic_id;
        $appointments = $this->getMissedServiceAppointments($clinicId);
        $counts = $this->getServiceAppointmentCount($clinicId);
        return view('admin.services.missedServiceAppointment', compact('appointments','clinic','counts'));
    }
    //booked appointment list
    private function getBookedServiceAppointments($clinicId)
    {
        return ServiceAppointment::select('service_appointments.*', 'services.name as service_name')
        ->where('service_appointments.clinic_id', $clinicId)
        ->where('status', 'booked')
        ->leftJoin('Services', 'services.id', 'service_appointments.service_id')
        ->get();
    }

    //record sent appointment list
    private function getRecordedServicAppointments($clinicId)
    {
        return ServiceAppointment::select('service_appointments.*', 'services.name as service_name')
        ->where('service_appointments.clinic_id', $clinicId)
        ->where('status', 'recorded')
        ->leftJoin('Services', 'services.id', 'service_appointments.service_id')
        ->get();
    }
    //cancelled appointment list
    private function getCancelledServicAppointments($clinicId)
    {
        return ServiceAppointment::select('service_appointments.*', 'services.name as service_name')
        ->where('service_appointments.clinic_id', $clinicId)
        ->where('status', 'cancelled')
        ->leftJoin('Services', 'services.id', 'service_appointments.service_id')
        ->get();
    }
    //missed appointment list
    private function getMissedServiceAppointments($clinicId){
        $today = now()->toDateString();
        return ServiceAppointment::select('service_appointments.*', 'services.name as service_name')
        ->where('service_appointments.clinic_id', $clinicId)
        ->whereDate('service_appointments.appointment_date','>=', $today)
        ->where('status', 'booked')
        ->leftJoin('Services', 'services.id', 'service_appointments.service_id')
        ->get();
    }
    private function getServiceAppointmentCount($clinicId){
        $booked = $this->getBookedServiceAppointments($clinicId)->count();
        $recorded = $this->getRecordedServicAppointments($clinicId)->count();
        $cancelled = $this->getCancelledServicAppointments($clinicId)->count();
        $missed = $this->getMissedServiceAppointments($clinicId)->count();
        return [$booked, $recorded, $cancelled, $missed];
    }

    //retrieve clinic info
    private function clinicInfo()
    {
        return User::select('users.*', 'clinics.*', 'clinics.name as clinic_name', 'clinics.phone as clinic_phone')
            ->where('users.id', Auth::user()->id)
            ->leftJoin('clinics', 'users.clinic_id', 'clinics.id')->first();
    }

    private function formatServiceInfo(Request $request)
    {
        return [
            'name' => $request->name,
            'photo' => $request->photo,
            'category_id' => $request->category,
            'clinic_id' => Auth::user()->clinic_id,
            'description' => $request->description,
            'components' => $request->input('components', []),
            'price' => $request->price,
            'promotion_rate' => $request->rate,
            'promotion' => $request->promotion
        ];
    }
}
