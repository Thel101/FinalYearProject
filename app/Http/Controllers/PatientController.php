<?php

namespace App\Http\Controllers;

use App\Models\ServiceMedicalRecords;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinics;
use App\Models\Doctors;
use App\Models\Services;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\DoctorAppointment;
use App\Models\DoctorMedicalRecords;
use App\Models\ServiceAppointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    //home page
    public function home()
    {
        $services = ServiceCategory::take(3)->get();
        $serviceCount = Services::get();
        $specialties = Specialty::get();
        $doctors = Doctors::select('doctors.*', 'specialties.name as specialty_name')
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
            ->take(4)->get();
        $clinics = Clinics::take(3)->get();
        $patients = User::where('role', 'user')->get();
        // dd($patients);
        return view('patient.home', [
            'services' => $services,
            'serviceCount' => $serviceCount,
            'specialties' => $specialties,
            'doctors' => $doctors,
            'patients' => $patients,
            'clinics' => $clinics

        ]);
    }
    public function homeSearch(Request $request)
    {
        $result = '';
        if (request('searchedTownship')) {
            $clinics = Clinics::where('township', 'LIKE', "%" . request('searchedTownship') . "%")->take(4)->get();

            if (count($clinics) > 0) {
                $result = '<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone</th>
                                </tr>
                            </thead>
                            <tbody>';

                foreach ($clinics as $row) {
                    $result .= '<tr>
                                    <th scope="row">' . $row->name . '</th>
                                    <td>' . $row->address . '</td>
                                    <td>' . $row->phone . '</td>
                                    <td><a href="/search/clinic/details/' . $row->id . '">Details</a></td>

                                </tr>';
                }

                $result .= '</tbody></table>';
            } else {
                $result = '<p>No clinics found.</p>';
            }

            return $result;
        }
    }
    public function clinicDetail($id)
    {
        $clinic = Clinics::find($id)->first();
        $clinicID = $clinic->id;
        $services = Services::where('clinic_id', $clinicID)->get();

        $doctors = $clinic->doctors->unique();
        return view('patient.clinicDetail', compact('clinic', 'services','doctors'));
    }
    //clinic Section
    public function clinicDisplay($id)
    {
        $clinic = Clinics::where('id', $id)->get();
        // logger($clinic);
        return response()->json([
            'status' => 'success',
            'clinicData' => $clinic
        ]);
    }
    //register form
    public function registerPatient()
    {
        return view('patient.register');
    }
    //register function
    public function patientRegister(Request $request)
    {
        $action = "register";
        $this->validatePatientInfo($request, $action);
        $data = $this->formatPatientInfo($request, $action);
        User::create($data);
        return redirect()->route('patient.home');
    }
    //patient profile
    public function profile()
    {
        return view('patient.Account.profile');
    }
    //patient dashboard profile details
    public function profileDetails()
    {
        $user = User::find(Auth::user()->id);
        return view('patient.Account.profilePage', compact('user'));
    }
    //update profile
    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $action = 'update';

        // $this->validatePatientInfo($request, $action);
        $data = $this->formatPatientInfo($request, $action);
        if ($request->hasFile('profilePhoto')) {
            $filename = uniqid() . $request->file('profilePhoto')->getClientOriginalName();
            $request->file('profilePhoto')->storeAs('public/', $filename);
            $data['profile_photo_path'] = $filename;
        }
        User::where('id', Auth::user()->id)->update($data);
        return back()->with(['success' => "Profile Updated!"]);
    }
    //change password page
    public function changePasswordPage(Request $request)
    {
        return view('patient.changePassword');
    }
    public function changePassword(Request $request)
    {
        // dd($request->toArray());
        $this->validatePassword($request);
        $data = $this->formatPassword($request);

        // dd($data);
        $user = User::select('password')->where('id', Auth::user()->id)->first();
        $dbHashValue = $user->password;
        if (Hash::check($data['currentPassword'], $dbHashValue)) {

            $newPassword = [
                'password' => Hash::make($data['newPassword'])
            ];

            User::where('id', Auth::user()->id)->update($newPassword);

            return redirect()->route('patient.changePassword')->with(['successMessage' => 'Password has been updated successfully!']);
        }
        // dd('fail');
        return redirect()->route('patient.changePassword')->with(['errorMessage' => 'Credential does not match!']);
    }

    //patient dashboard service appointment list
    public function serviceAppointmentList()
    {
        $appointments = ServiceAppointment::select(
            'service_appointments.*',
            'services.name as service_name',
            'clinics.name as clinic_name',
            'clinics.address as clinic_address',
            'clinics.township as clinic_township',
        )
            ->where('booking_person', Auth::user()->id)
            ->leftJoin('services', 'services.id', 'service_appointments.service_id')
            ->leftJoin('clinics', 'clinics.id', 'service_appointments.clinic_id')
            ->get();
        $today = Carbon::now();
        $twoDaysBefore = $today->copy()->subDay(2);

        foreach ($appointments as $appointment){
            if ($appointment->appointment_date->isSameDay($twoDaysBefore) && $appointment->status == 'booked') {
                $appointment->status = 'missed';
                $appointment->save();
            }
        }

        foreach ($appointments as $appointment) {
            $differenceInDays = $today->diffInDays($appointment->appointment_date, false);
            if ($differenceInDays <= 2 && $differenceInDays > 1) {
                $appointment->isWithinRange = false;
            } else {
                $appointment->isWithinRange = true;
            }

        }
        return view('patient.serviceAppointments.serviceAppointmentList', compact('appointments'));
    }
    //patient dashboard doctor appointment list
    public function doctorAppointmentList()
    {

        $appointments = DoctorAppointment::select(
            'doctor_appointments.*',
            'doctors.name as doctor_name',
            'clinics.name as clinic_name',
            'clinics.address as clinic_address',
            'clinics.township as clinic_township',
            'specialties.name as specialty_name'
        )
            ->where('booking_person', Auth::user()->id)
            ->leftJoin('doctors', 'doctors.id', 'doctor_appointments.doctor_id')
            ->leftJoin('clinics', 'clinics.id', 'doctor_appointments.clinic_id')
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
            ->get();
        $today = Carbon::now();

        foreach ($appointments as $appointment){
            if(($today > $appointment->appointment_date) && $appointment->status== 'booked') {
                $appointment->status = 'missed';
                $appointment->save();
            }
        }

        foreach ($appointments as $appointment) {
            $differenceInDays = $today->diffInDays($appointment->appointment_date, false);
            if ($differenceInDays <= 2 && $differenceInDays != 0) {
                $appointment->isWithinRange = false;
            } else {
                $appointment->isWithinRange = true;
            }

        }

        return view('patient.doctorAppointments.doctorAppointmentList', compact('appointments'));
    }
    //patient dashboard medical record list
    public function records()
    {
        $consultationRecordLists = DoctorMedicalRecords::select('doctor_medical_records.*','doctors.name as doctor_name', 'doctor_appointments.appointment_date as appointment_date')
        ->leftJoin('doctor_appointments','doctor_appointments.id','doctor_medical_records.appointment_id')
        ->leftJoin('doctors','doctors.id','doctor_appointments.doctor_id')
        ->where('doctor_appointments.patient_id',Auth::user()->id)->get();
        $serviceRecordLists= ServiceMedicalRecords::select(
            'service_medical_records.*',
            'service_appointments.appointment_date as appointment_date',
            'services.name as service_name')
        ->where('service_medical_records.patient_id', Auth::user()->id)
        ->leftJoin('service_appointments', 'service_appointments.id', 'service_medical_records.service_appointment_id')
        ->leftJoin('services','services.id','service_appointments.service_id')
        ->get();
        return view('patient.Account.recordList', compact('serviceRecordLists','consultationRecordLists'));
    }
    //doctor record detail
    public function viewConsultRecordDetail($id){
        $doctorMedicalRecords = DoctorMedicalRecords::select('doctor_medical_records.*', 'doctor_appointments.*')
        ->where('appointment_id',$id)
        ->leftJoin('doctor_appointments','doctor_medical_records.appointment_id','doctor_appointments.id')
        ->first();
        return view('patient.Account.consultRecordDetail', compact('doctorMedicalRecords'));
    }
    //service List display
    public function serviceDetails($id)
    {
        $service = Services::select('services.*', 'service_categories.name as category_name')
            ->where('services.category_id', $id)
            ->leftJoin('service_categories', 'service_categories.id', 'services.category_id')
            ->get();
        $currentCategory = null;
        return view('patient.serviceDetail', compact('service', 'currentCategory'));
    }
    //service details with clinic info
    public function serviceClinicDetails($id)
    {
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
    public function doctorDetails($did)
    {

        //specific doctor
        $doctor = Doctors::select('doctors.*', 'specialties.name as specialty_name')
            ->where('doctors.id', $did)
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')
            ->first();
        //other similar doctors
        $doctor_specialty = $doctor->specialty_id;
        $doctors = Doctors::select('doctors.*')
            ->where('specialty_id', $doctor_specialty)
            ->where('doctors.id', '!=', $did)
            ->leftJoin('specialties', 'specialties.id', 'doctors.specialty_id')->get();
        return view('patient.doctorDetail', compact('doctor', 'doctors'));
    }

    //format patient info
    private function formatPatientInfo(Request $request, $action)
    {
        if ($action == 'register') {
            return [
                'name' => $request->patientName,
                'email' => $request->patientEmail,
                'phone1' => $request->patientPhone,
                'address' => $request->patientAddress,
                'role' => 'user',
                'password' => Hash::make($request->patientPassword)
            ];
        } else {
            return [
                'name' => $request->updateName,
                'email' => $request->updateEmail,
                'phone1' => $request->updatePhone1,
                'phone2' => $request->updatePhone2,
                'address' => $request->updateAddress,
                'role' => 'user'
            ];
        }
    }
    //validate patient info
    private function validatePatientInfo(Request $request, $action)
    {
        if ($action == 'register') {
            $validate = [
                'patientName' => 'required|min:5',
                'patientEmail' => 'required|unique:users,email',
                'patientPhone' => 'required|numeric',
                'patientAddress' => 'required|min:5',
                'patientPassword' => 'required'
            ];
        } else {
            $userId = Auth::user()->id; // Get the current user's ID

            $validate = [
                'updateName' => 'required|min:5',
                'updateEmail' => 'required|unique:users,email,' . $userId,
                'updatePhone1' => 'required|numeric',
                'updatePhone2' => 'numeric',
                'updateAddress' => 'required|min:5'
            ];
        }
        Validator::make($request->all(), $validate)->validate();
    }
    //validate password
    private function validatePassword($request)
    {
        Validator::make($request->all(), [
            'currentPassword' => 'required|min:6|max:10',
            'newPassword' => 'required|min:6|max:10',
            'confirmPassword' => 'required|min:6|max:10|same:newPassword'
        ])->validate();
    }
    //format password
    private function formatPassword(Request $request)
    {
        return [
            'currentPassword' => $request->currentPassword,
            'newPassword' => $request->newPassword,
            'confirmPassword' => $request->confirmPassword
        ];
    }
}
