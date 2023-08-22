<?php

namespace App\Http\Controllers\Admin;

use session;
use App\Models\User;
use App\Models\Clinics;
use App\Models\Doctors;
use App\Models\Services;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
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

    //doctor list
    public function doctorList()
    {
        $clinic = $this->clinicInfo();
        $clinicId = Auth::user()->clinic_id;
        $doctors = Doctors::select('doctors.*', 'specialties.name as specialty_name')
            ->distinct()
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
            ->rightJoin('clinics_doctors', 'clinics_doctors.doctors_id', 'doctors.id')
            ->where('clinics_doctors.clinics_id', $clinicId)->get();

        return view('admin.doctorList', compact('doctors', 'clinic'));
    }
    //direct to register form
    public function registerForm()
    {
        $specialties = Specialty::get();
        $clinic = $this->clinicInfo();

        return view('admin.registerDoctor', compact('clinic', 'specialties'));
    }
    //register doctor
    public function registerDoctor(Request $request)
    {
        $clinic = $this->clinicInfo();
        $this->validateDoctorInfo($request);
        $data = $this->formatDoctorInfo($request);
        $filename = uniqid() . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('public/', $filename);
        $data['photo'] = $filename;
        $days = $request->day;
        $starts = $request->startTime;
        $ends = $request->endTime;


        $existing_doctor = Doctors::where('license_no', $data['license_no'])
            ->where('specialty_id', $data['specialty_id'])
            ->first();
        if ($existing_doctor) {

            return view('admin.addDoctor', compact('clinic', 'existing_doctor'));
        } else {
            $doctor = Doctors::create($data);
            $clinicId = Auth::user()->clinic_id;
            foreach ($days as $key => $day) {
                $start = $starts[$key];
                $end = $ends[$key];
                $doctor->clinics()->attach($clinicId,
                ['schedule_day' => $day,
                'start_time' => $start,
                'end_time' => $end]);

            }
            return redirect()->route('admin.doctorList')->with(['message' => 'Doctor registered successfully']);
        }
    }
    //add existing doctor
    public function addDoctor(Request $request)
    {
        $doctorId = $request->doctorId;
        $clinicId = Auth::user()->clinic_id;
        $doctor = Doctors::find($doctorId);
        $days= $request->day;
        $starts = $request->startTime;
        $ends = $request->endTime;
        if ($doctor) {
            foreach ($days as $key => $day) {
                $start = $starts[$key];
                $end = $ends[$key];
                $doctor->clinics()->attach($clinicId,
                ['schedule_day' => $day,
                'start_time' => $start,
                'end_time' => $end]);

        }
    }
        return redirect()->route('admin.doctorList')->with(['message' => 'Doctor Has Been Added Successfully']);
    }
    //remove doctor from clinic
    public function removeDoctor(Request $request)
    {
        $id = $request->doctorId;
        $doctor = Doctors::find($id);
        $clinicId = Auth::user()->clinic_id;
        $doctor->clinics()->detach($clinicId);
    }
    // doctor schedule form
    public function scheduleForm($id)
    {
        $clinic = $this->clinicInfo();
        $doctor = Doctors::where('id', $id)->first();
        return view('admin.addDocSchedule', compact('clinic', 'doctor'));
    }

    //add doctor schedules
    public function addSchedules(Request $request)
    {

        $doctorId = $request->doctorId;
        $clinicId = Auth::user()->clinic_id;
        $days = $request->day;
        $starts = $request->startTime;
        $ends = $request->endTime;
        $doctor = Doctors::find($doctorId);
        foreach ($days as $key => $day) {
            $start = $starts[$key];
            $end = $ends[$key];

            $doctor->clinics()->updateExistingPivot(
                $clinicId,
                [
                    'schedule_day' => $day,
                    'start_time' => $start,
                    'end_time' => $end
                ]
            );
        }
        dd('success');
    }
    //service list
    public function serviceList()
    {

        $clinic = $this->clinicInfo();
        $services = Services::select('services.*', 'service_categories.name as category_name')
            ->leftJoin('service_categories', 'service_categories.id', 'services.category_id')
            ->get();
        return view('admin.serviceList', compact('services', 'clinic'));
    }
    //service register form
    public function registerFormService()
    {
        $clinic = $this->clinicInfo();
        $category = ServiceCategory::get();
        return view('admin.registerService', compact('clinic', 'category'));
    }
    //register service
    public function registeService(Request $request)
    {
        $data = $this->formatServiceInfo($request);
        $filename = uniqid() . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('public/', $filename);
        $data['photo'] = $filename;

        Services::create($data);
        return redirect()->route('admin.serviceList')->with(['message' => 'Service Registered Successfully']);
    }


    //retrieve clinic info
    private function clinicInfo()
    {
        return User::select('users.*', 'clinics.*', 'clinics.name as clinic_name', 'clinics.phone as clinic_phone')
            ->where('users.id', Auth::user()->id)
            ->leftJoin('clinics', 'users.clinic_id', 'clinics.id')->first();
    }
    //format doctor info
    private function formatDoctorInfo(Request $request)
    {
        return [
            'name' => 'Dr ' . $request->name,
            'license_no' => $request->license,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialty_id' => $request->specialty,
            'degree' => $request->degree,
            'experience' => $request->experience,
            'consultation_fees' => $request->fees,
            'photo' => $request->photo,
            'schedule_day' =>$request->input('day',[]),
            'start_time'=>$request->input('startTime',[]),
            'end_time'=> $request->input('endTime',[])
        ];
    }
    private function validateDoctorInfo(Request $request)
    {
        $validationRules = [
            'license_no' => ['unique:doctors'],
            'photo' => ['required', 'mimes:jpeg, jpg, png, webp']
        ];
        Validator::make($request->all(), $validationRules)->validate();
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
