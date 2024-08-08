<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Clinics;
use App\Models\Doctors;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\DoctorAppointment;
use App\Models\DoctorMedicalRecords;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    //doctor list
    public function doctorList()
    {
        $clinic = $this->clinicInfo();
        $clinicId = Auth::user()->clinic_id;
        $specialties = Specialty::get();
        $doctors = Doctors::select('doctors.*', 'specialties.name as specialty_name')
            ->distinct()
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
            ->rightJoin('clinics_doctors', 'clinics_doctors.doctors_id', 'doctors.id')
            ->where('clinics_doctors.clinics_id', $clinicId)->get();
        return view('admin.doctors.doctorList', compact('doctors', 'clinic', 'specialties'));
    }
    //direct to register form
    public function registerForm()
    {
        $specialties = Specialty::get();
        $clinic = $this->clinicInfo();

        return view('admin.doctors.registerDoctor', compact('clinic', 'specialties'));
    }
    //register doctor
    public function registerDoctor(Request $request)
    {
        $action = "create";
        // dd($request->toArray());
        $clinic = $this->clinicInfo();
        // logger($end);
        $data = $this->formatDoctorInfo($request);
        $filename = uniqid() . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('public/', $filename);
        $data['photo'] = $filename;
        $days = $request->day;
        $starts = $request->startTime;
        $ends = $request->endTime;
        // dd($ends);
        // dd($data);

        $existing_doctor = Doctors::where('license_no', $data['license_no'])
            ->where('specialty_id', $data['specialty_id'])
            ->first();
        if ($existing_doctor) {

            return view('admin.doctors.addDoctor', compact('clinic', 'existing_doctor'));
        } else {

            // dd($data);
            $doctor = Doctors::create($data);
            // dd($doctor->toArray());
            $clinicId = Auth::user()->clinic_id;
            foreach ($days as $key => $day) {
                $start = $starts[$key];
                $end = $ends[$key];
                $doctor->clinics()->attach(
                    $clinicId,
                    [
                        'schedule_day' => $day,
                        'start_time' => $start,
                        'end_time' => $end
                    ]
                );
                return redirect()->route('admin.doctorList')->with(['message' => 'Doctor registered successfully']);
            }
            // dd($result);

        }
    }
    //add existing doctor
    public function addDoctor(Request $request)
    {

        $doctorId = $request->doctorID;
        $clinicId = Auth::user()->clinic_id;
        $doctor = Doctors::find($doctorId);
        $days = $request->day;
        $starts = $request->startTime;
        $ends = $request->endTime;
        if ($doctor) {
            foreach ($days as $key => $day) {
                $start = $starts[$key];
                $end = $ends[$key];
                $doctor->clinics()->attach(
                    $clinicId,
                    [
                        'schedule_day' => $day,
                        'start_time' => $start,
                        'end_time' => $end
                    ]
                );
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
        return redirect()->route('admin.doctorList')->with(['DeactivateSuccess' => "Doctor has been removed from clinic"]);
    }
    //doctors' schedule list
    public function doctorSchedules()
    {

        $clinicId = Auth::user()->clinic_id;
        $clinic = $this->clinicInfo();
        $doctorSchedules = Doctors::whereHas('clinics', function ($query) use ($clinicId) {
            $query->where('clinics_id', $clinicId);
        })->get();

        $schedules = [];
        $doctorSchedulesWithScheduleDays = [];

        foreach ($doctorSchedules as $doctor) {
            foreach ($doctor->clinics as $clinic) {
                $clinic_id = $clinic->id;
                if ($clinic_id == $clinicId) {
                    $doctorId = $doctor->id;
                    $docSpecialty = $this->getSpecialty($doctorId);
                    $doctorName = $doctor->name;
                    $scheduleDay = $clinic->pivot->schedule_day;
                    $startTime = $clinic->pivot->start_time;
                    $endTime = $clinic->pivot->end_time;
                    $doctorSchedulesWithScheduleDays[] = [
                        'clinic_id' => $clinic_id,
                        'doctor_id' => $doctorId,
                        'doctor_name' => $doctorName,
                        'doctor_specialty' => $docSpecialty,
                        'schedule_day' => $scheduleDay,
                        'start_time' => $startTime,
                        'end_time' => $endTime

                    ];
                }
            }
        }


        return view('admin.doctors.doctorSchedule', compact('clinic', 'doctorSchedulesWithScheduleDays'));
    }
    private function getSpecialty($doc_id)
    {

        $specialty = Doctors::select('specialties.name as specialty_name')
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
            ->where('doctors.id', $doc_id)->first();
        $specialtyName = $specialty->specialty_name;
        return $specialtyName;
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
    //view doctor details
    public function doctorDetail($id)
    {
        $clinic = $this->clinicInfo();
        $specialties = Specialty::get();
        $doctorSpecialty = Doctors::select('specialties.id as specialty_id', 'specialties.name as specialty_name')
            ->where('doctors.id', $id)
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')->first();
        $doctor = Doctors::with('clinics')->find($id);
        // dd($doctor->toArray());
        return view('admin.doctors.doctorDetail', compact('doctor', 'clinic', 'doctorSpecialty', 'specialties'));
    }
    //edit doctor function
    public function doctorEdit(Request $request)
    {

        $clinic_id = Auth::user()->clinic_id;
        // $this->validateDoctorInfo($request, "edit");
        $data = $this->formatDoctorInfo($request);
        $docId = $request->docID;

        if ($request->hasFile('photo')) {
            $oldImage = Doctors::where('id', $request->docID)->first();
            $dbImage = $oldImage->photo;
            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            $filename = uniqid() . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('public/', $filename);
            $data['photo'] = $filename;
        }
        $days = $request->day;
        $startTimes = $request->startTime;
        $endTimes = $request->endTime;

        $doctor = Doctors::find($docId);
        $doctor->update($data);

        $scheduleData = [];

        for ($i = 0; $i < count($days); $i++) {
            $scheduleData[] = [
                'clinics_id' => $clinic_id,
                'schedule_day' => $days[$i],
                'start_time' => $startTimes[$i],
                'end_time' => $endTimes[$i],
            ];
        }

        $doctor->clinics()->sync($scheduleData);
        return redirect()->route('admin.doctorList')->with(['EditSuccess' => 'Doctor Information Updated Successfully']);
    }
    //doctor self update
    public function doctorProfileEdit(Request $request)
    {
        $data = $this->formatDoctorInfo($request);
        $docId = $request->docID;
        if ($request->hasFile('photo')) {
            $oldImage = Doctors::where('id', $request->docID)->first();
            $dbImage = $oldImage->photo;
            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            $filename = uniqid() . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('public/', $filename);
            $data['photo'] = $filename;
        }
        $doctor = Doctors::find($docId);
        $doctor->update($data);
        return back()->with(['A' => 'Profile Updated Successfully']);
    }
    public function searchDoctor()
    {
        $clinic = $this->clinicInfo();
        $doctors = [];
        return view('admin.doctors.searchDoctor', compact('clinic', 'doctors'));
    }
    public function searchDuplicateDoctor($dId)
    {
        $docID = $dId;
        $clinicID = Auth::user()->clinic_id;
        $doctors = Doctors::find($docID)->clinics()->where('clinics_id', $clinicID)->exists();
        // logger($doctors);
        if ($doctors) {
            logger($doctors);
            return response()->json(['message' => 'Doctor Schedule already exists in the clinic']);
        }
    }


    public function searchDoctorFunction(Request $request)
    {
        $clinic = $this->clinicInfo();
        $doctor_name = $request->input('doctorName');
        $specialty = $request->input('doctorSpecialty');
        $doctors = Doctors::select('doctors.*', 'specialties.name as specialty_name')
            ->leftJoin('specialties', 'doctors.specialty_id', 'specialties.id')
            ->where('doctors.name', 'LIKE', "%{$doctor_name}%")
            ->distinct()
            ->get();
        if (count($doctors) > 0) {
            return view('admin.doctors.searchDoctor', compact('clinic', 'doctors'));
        } else {
            return redirect()->route('admin.searchDoctorForm')->with(['message' => 'No results found!']);
        }
    }

    public function dashboard()
    {
        $doctor = $this->doctorDasbhoard();
        return view('doctor.doctorDashboard', compact('doctor'));
    }

    public function doctorProfile()
    {
        $doctor = $this->doctorDasbhoard();
        $docEmail = Session::get('email');
        $doc = Doctors::select('doctors.*', 'specialties.name as specialty_name, specialties.id as specialty_id')
            ->where('doctors.email', $docEmail)
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
            ->first();

        return view('doctor.doctorProfile', compact('doc', 'doctor'));
    }
    public function doctorDashboardAppointment()
    {
        $doctor = $this->doctorDasbhoard();
        // $docID = $doctor->id;
        $counts = $this->getDoctorAppointmentCount($docID);

        return view('doctor.appointmentTableTemplate', compact('doctor', 'counts'));
    }

    //doctor dasbhoard upcoming appointments
    public function newAppointment()
    {
        $doctor = $this->doctorDasbhoard();
        $docID = $doctor->id;
        $appointments = $this->getUpcomingDoctorAppointments($docID);
        $counts = $this->getDoctorAppointmentCount($docID);
        return view('doctor.appointments', compact('appointments', 'doctor', 'counts'));
    }
    //doctor dashboard past appointments
    public function consultedAppointments()
    {
        $doctor = $this->doctorDasbhoard();
        $docID = $doctor->id;
        $con_appointments = $this->getPastDoctorAppointments($docID);
        $counts = $this->getDoctorAppointmentCount($docID);
        return view('doctor.consultedAppointments', compact('con_appointments', 'doctor', 'counts'));
    }
    //doctor dashboard cancelled appointments
    public function cancelledAppointments()
    {
        $doctor = $this->doctorDasbhoard();
        $docID = $doctor->id;
        $cancelled_appointments = $this->getCancelledDoctorAppointments($docID);
        $counts = $this->getDoctorAppointmentCount($docID);
        return view('doctor.cancelledAppointments', compact('cancelled_appointments', 'doctor', 'counts'));
    }
    //missed appointments
    public function missedAppointments()
    {
        $doctor = $this->doctorDasbhoard();
        $docID = $doctor->id;
        $missed_appointments = $this->getMissedDoctorAppointments($docID);
        $counts = $this->getDoctorAppointmentCount($docID);
        return view('doctor.missedAppointments', compact('missed_appointments', 'doctor', 'counts'));
    }
    //direct to medical records upload page
    public function recordsUpload($id)
    {
        $doctor = $this->doctorDasbhoard();
        $appointment = $this->appointmentRecord($id);
        return view('doctor.medicalRecordsUpload', compact('doctor', 'appointment'));
    }

    //appointment details
    private function appointmentRecord($id)
    {
        return DoctorAppointment::select(
            'doctor_appointments.*',
            'users.name as patient_name',
            'clinics.name as clinic_name',
            'clinics.address as clinic_address',
            'clinics.township as clinic_township'
        )
            ->where('doctor_appointments.id', $id)
            ->leftJoin('users', 'users.id', 'doctor_appointments.booking_person')
            ->leftJoin('clinics', 'clinics.id', 'doctor_appointments.clinic_id')
            ->first();
    }
    //upcoming appointment list
    private function getUpcomingDoctorAppointments($doctorId)
    {
        return DoctorAppointment::select(
            'doctor_appointments.*',
            'users.name as patient_name',
            'clinics.name as clinic_name',
            'clinics.address as clinic_address',
            'clinics.township as clinic_township'
        )
            ->where('doctor_appointments.doctor_id', $doctorId)
            ->where('doctor_appointments.status', 'booked')
            ->leftJoin('users', 'users.id', 'doctor_appointments.booking_person')
            ->leftJoin('clinics', 'clinics.id', 'doctor_appointments.clinic_id')
            ->get();
    }

    //past appointment list
    private function getPastDoctorAppointments($doctorId)
    {
        return DoctorAppointment::select(
            'doctor_appointments.*',
            'users.name as patient_name',
            'clinics.name as clinic_name',
            'clinics.address as clinic_address',
            'clinics.township as clinic_township'
        )
            ->where('doctor_appointments.doctor_id', $doctorId)
            ->where('doctor_appointments.status', 'consulted')
            ->leftJoin('users', 'users.id', 'doctor_appointments.booking_person')
            ->leftJoin('clinics', 'clinics.id', 'doctor_appointments.clinic_id')
            ->get();
    }
    private function getCancelledDoctorAppointments($doctorId)
    {
        return DoctorAppointment::select(
            'doctor_appointments.*',
            'users.name as patient_name',
            'clinics.name as clinic_name',
            'clinics.address as clinic_address',
            'clinics.township as clinic_township'
        )
            ->where('doctor_appointments.doctor_id', $doctorId)
            ->where('doctor_appointments.status', 'cancelled')
            ->leftJoin('users', 'users.id', 'doctor_appointments.booking_person')
            ->leftJoin('clinics', 'clinics.id', 'doctor_appointments.clinic_id')
            ->get();
    }
    private function getMissedDoctorAppointments($doctorId)
    {
        $today = now()->toDateString();

        return DoctorAppointment::select(
            'doctor_appointments.*',
            'users.name as patient_name',
            'clinics.name as clinic_name',
            'clinics.address as clinic_address',
            'clinics.township as clinic_township'
        )
            ->where('doctor_appointments.doctor_id', $doctorId)
            ->where('doctor_appointments.status', 'cancelled')
            ->whereDate('doctor_appointments.appointment_date', '>=', $today)
            ->leftJoin('users', 'users.id', 'doctor_appointments.booking_person')
            ->leftJoin('clinics', 'clinics.id', 'doctor_appointments.clinic_id')
            ->get();
    }
    private function getDoctorAppointmentCount($doctorId)
    {
        $new = $this->getUpcomingDoctorAppointments($doctorId)->count();
        $consulted = $this->getPastDoctorAppointments($doctorId)->count();
        $cancelled = $this->getCancelledDoctorAppointments($doctorId)->count();
        $missed = $this->getMissedDoctorAppointments($doctorId)->count();
        return [$new, $consulted, $cancelled, $missed];
    }
    //doctor profile for Dashboard
    private function doctorDasbhoard()
    {
        return Doctors::where('email', Session::get('email'))->first();
    }
    //get doctor information for edit modal form
    private function getDoctorInfo($dId)
    {

        $clinicId = Auth::user()->clinic_id;
        return Doctors::with(['clinics' => function ($query) use ($clinicId) {
            $query->where('clinics.id', $clinicId)->withPivot('schedule_day', 'start_time', 'end_time');
        }])
            ->select('doctors.*', 'specialties.name as specialty')
            ->where('doctors.id', $dId)
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')->first();
    }
    //get doctor schedules from pivot table
    private function getDoctorSchedules($doctor)
    {
        $scheduleDays = [];

        if ($doctor) {
            foreach ($doctor->clinics as $clinic) {
                $pivotData = $clinic->pivot;
                $scheduleDay = $pivotData->schedule_day;
                $start = $pivotData->start_time;
                $end = $pivotData->end_time;
                $scheduleDays[] = compact('scheduleDay', 'start', 'end');
            }
        }
        return $scheduleDays;
    }
    //format doctor info
    private function formatDoctorInfo(Request $request)
    {
        return [
            'name' => $request->name,
            'license_no' => $request->license,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialty_id' => $request->specialty,
            'degree' => $request->degree,
            'experience' => $request->experience,
            'consultation_fees' => $request->fees,
            'consultation_duration' => $request->duration,
            'schedule_day' => $request->input('day', []),
            'start_time' => $request->input('startTime', []),
            'end_time' => $request->input('endTime', [])
        ];
    }
    private function validateDoctorInfo(Request $request, $action)
    {
        $validationRules = [
            'name' => 'required',
            'license' => 'required|unique:doctors,license_no',
            'email' => 'required',
            'phone' => 'required',
            'specialty' => 'required',
            'degree' => 'required',
            'experience' => 'required',
            'fees' => 'required',
            'duration' => 'required',
        ];
        if ($action === "edit") {
            $validationRules['photo'] = 'nullable|mimes:jpeg,jpg,png,webp';
        } else {
            $validationRules['photo'] = 'required|mimes:jpeg,jpg,png,webp';
        }
        Validator::make($request->all(), $validationRules)->validate();
    }
    //retrieve clinic info
    private function clinicInfo()
    {
        return User::select('users.*', 'clinics.*', 'clinics.name as clinic_name', 'clinics.phone as clinic_phone')
            ->where('users.id', Auth::user()->id)
            ->leftJoin('clinics', 'users.clinic_id', 'clinics.id')->first();
    }
}
