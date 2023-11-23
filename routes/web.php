<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicAdminsController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorMedicalRecordsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceAppointmentController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\SpecialtyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PatientController::class, 'home'])->name('patient.home');
Route::get('/search', [PatientController::class, 'homeSearch'])->name('patient.searchClinicTownship');
Route::get('/search/clinic/details/{id}',[PatientController::class,'clinicDetail'])->name('patient.searchedClinic');
Route::get('/doctor/loginForm',[AuthController::class, 'loginForm'])->name('doctor.loginForm');
Route::post('/doctor/login',[AuthController::class, 'doctorLogin'])->name('doctor.login');
Route::get('/patient/clinic/{id}',[PatientController::class, 'clinicDisplay'])->name('patient.clinics');

Route::get('/patient/register', [PatientController::class,'registerPatient'] )->name('patient.register');
Route::post('/patient/add',[PatientController::class, 'patientRegister'])->name('patient.add');
Route::get('/patient/services',[PatientController::class, 'serviceList'])->name('patient.services');
Route::get('patient/service/details/{id}',[PatientController::class, 'serviceDetails'])->name('patient.serviceDetails');
Route::get('patient/service/clinic/details/{id}',[PatientController::class, 'serviceClinicDetails'])->name('patient.serviceClinic');
Route::prefix('patient/doctor')->group(function(){
    Route::get('/details/{id}', [PatientController::class, 'doctorDetails'])->name('patient.doctorDetails');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::middleware('super_admin')->group(function () {
        Route::get('/clinic/form', [SuperAdminController::class, 'registerClinic'])->name('superAdmin.clinic');
        Route::prefix('superadmin/clinics')->group(function () {
            Route::post('/register', [SuperAdminController::class, 'Clinic'])->name('clinic.register');
            Route::get('/list', [SuperAdminController::class, 'clinicList'])->name('clinic.list');
            Route::get('/edit/{id}', [SuperAdminController::class, 'editForm'])->name('clinic.editForm');
            Route::post('/edit', [SuperAdminController::class, 'editClinic'])->name('clinic.edit');
            Route::get('/deactivate', [SuperAdminController::class, 'deactivateClinic'])->name('clinic.deactivate');

            Route::prefix('/admins')->group(function () {
                Route::get('/', [ClinicAdminsController::class, 'admin'])->name('admin.list');
                Route::get('/register', [ClinicAdminsController::class, 'registerAdmin'])->name(('admin.registerForm'));
                Route::post('/register', [ClinicAdminsController::class, 'createAdmin'])->name(('admin.register'));
                Route::get('/edit/{id}', [ClinicAdminsController::class, 'editForm'])->name('admin.editForm');
                Route::post('/edit', [ClinicAdminsController::class, 'editAdmin'])->name('admin.edit');
                Route::get('/inactive',[ClinicAdminsController::class, 'deactivateAdmin'])->name('admin.deactivate');

            });

            Route::prefix('/specialty')->group(function () {
                Route::get('/list', [SpecialtyController::class, 'specialty'])->name('specialty.list');
                Route::post('/register', [SpecialtyController::class, 'createSpecialty'])->name(('specialty.register'));
                Route::get('edit/{id}',[SpecialtyController::class, 'editSpecialtyForm'])->name('specialty.eidtForm');
                Route::post('edit',[SpecialtyController::class,'editSpecialty'])->name('specialty.edit');
            });

            Route::prefix('/serviceCategory')->group(function () {
                Route::get('/list', [ServiceCategoryController::class, 'serviceCategory'])->name('serviceCategory.list');
            Route::post('/register', [ServiceCategoryController::class, 'createServiceCategory'])->name(('serviceCategory.register'));
                Route::get('/edit/{id}', [ServiceCategoryController::class, 'editForm'])->name('serviceCategory.editForm');
                Route::post('/edit',[ServiceCategoryController::class, 'edit'])->name('serviceCategory.edit');
                Route::get('/duplicate', [ServiceCategoryController::class,'duplicateCategory'])->name('serviceCategory.duplicate');
            });
        });
    });
    Route::middleware(['admin'])->group(function () {
        Route::get('/clinic/profile', [AdminController::class, 'profile'])->name('admin.clinicProfile');
        Route::prefix('/admin')->group(function () {
            Route::get('/doctorList', [DoctorController::class, 'doctorList'])->name('admin.doctorList');
            Route::get('/doctor', [DoctorController::class, 'registerForm'])->name('admin.doctorForm');
            Route::get('/doctor/search', [DoctorController::class,'searchDoctor'])->name('admin.searchDoctorForm');
            Route::post('/doctor/search/results', [DoctorController::class,'searchDoctorFunction'])->name('admin.searchDoctor');
            Route::get('/doctor/search/results/{id}', [DoctorController::class,'searchDuplicateDoctor'])->name('admin.searchDuplicateDoctor');
            Route::post('/doctor/register', [DoctorController::class, 'registerDoctor'])->name('admin.doctorRegister');
            Route::post('/doctor/add', [DoctorController::class, 'addDoctor'])->name('admin.addDoctor');
            Route::get('/doctor/edit/{id}', [DoctorController::class, 'editDoctor'])->name('admin.editDoctor');
            Route::post('/doctor/edit',[DoctorController::class, 'doctorEdit'])->name('adminDoctor.edit');
            Route::get('/doctor/remove', [DoctorController::class, 'removeDoctor'])->name('admin.doctorRemove');
            Route::get('/doctor/detail/{id}',[DoctorController::class, 'doctorDetail'])->name('admin.doctorDetail');
            Route::get('/doctors/schedules/list',[DoctorController::class, 'doctorSchedules'])->name('doctors.schedules');
            Route::get('/schedulesForm/{id}', [DoctorController::class, 'scheduleForm'])->name('admin.docSchedules');
            Route::post('/schedules/add', [DoctorController::class, 'addSchedules'])->name('admin.addSchedules');
            Route::get('/doctor/appointments', [DoctorController::class,'doctorDashboardAppointment'])->name('admin.doctorAppointments');
            Route::get('/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
            Route::get('/specialty', [AdminController::class, 'specialty'])->name('admin.specialty');
            Route::get('/serviceList', [AdminController::class, 'serviceList'])->name('admin.serviceList');
            Route::get('/service', [AdminController::class, 'registerFormService'])->name('admin.serviceForm');
            Route::post('/service/register', [AdminController::class, 'registeService'])->name('admin.serviceRegister');
            Route::get('/service/appointments', [AdminController::class,'serviceAppointments'])->name('admin.serviceAppointments');
            Route::get('/service/result/{id}', [ServiceAppointmentController::class,'medicalResultsForm'])->name('admin.serviceResults');
            Route::post('/service/result/send', [ServiceAppointmentController::class,'sendMedicalResults'])->name('admin.sendResults');
            Route::get('/service/results/email', [MailController::class,'sendResultsEmail'])->name('admin.resultEmail');
            Route::get('/service/appointment/booked',[AdminController::class,'bookedAppointments'])->name('admin.bookedServices');
            Route::get('/service/appointment/recorded', [AdminController::class,'recordedAppointments'])->name('admin.recordedServices');
            Route::get('/service/appointment/cancel',[ServiceAppointmentController::class,'cancelAppointment'])->name('admin.serviceAppointmentCancel');
            Route::get('/service/appointment/cancelled', [AdminController::class,'cancelledAppointments'])->name('admin.cancelledServices');
            Route::get('/service/appointment/missed', [AdminController::class,'missedAppointments'])->name('admin.missedServices');

        });
    });
    Route::middleware(['patient'])->group(function(){
        Route::prefix('/patient')->group(function(){
            Route::get('/profile',[PatientController::class, 'profile'])->name('patient.profile');
            //service appointment routes
            Route::get('/service/appointment/{id}',[AppointmentController::class, 'appointmentPage'])->name('patient.appointment');
            Route::post('/appointment', [AppointmentController::class, 'serviceAppointment'])->name('service.appointment');
            Route::get('/date/appointment', [AppointmentController::class, 'appointmentDate'])->name('service.appointmentDate');
            Route::get('/service/confirm/appointment/email', [MailController::class, 'confirmServiceAppointmentEmail'])->name('serviceAppointment.email');
            Route::get('/service/cancel',[AppointmentController::class,'cancelAppointment'])->name('serviceAppointment.cancel');
            //doctor appointment routes
            Route::prefix('/doctors')->group(function(){
                Route::get('/appointment/page/{id}',[DoctorAppointmentController::class, 'docAppointmentPage'])->name('patient.docAppointmentPage');
                Route::get('/availability',[DoctorAppointmentController::class, 'doctorAvailability']);
                Route::post('/appointment', [DoctorAppointmentController::class, 'doctorAppointment'])->name('doctor.appointment');
                Route::get('/appointment/download/{id}',[DoctorAppointmentController::class, 'generatePDF'])->name('doctor.appointmentConfirm');
                Route::get('/appointment/email', [MailController::class, 'confirmEmail'])->name('doctorAppointment.email');
                Route::get('/appointment/cancel',[DoctorAppointmentController::class,'cancelAppointment'])->name('docAppointment.cancel');
            });
            Route::prefix('/dashboard')->group(function(){
                Route::get('/profile',[PatientController::class,'profileDetails'])->name('patient.profileDetails');
                Route::post('/profile/update', [PatientController::class,'updateProfile'])->name('patient.updateProfile');
                Route::get('/appointment/service/List',[PatientController::class, 'serviceAppointmentList'])->name('patient.serviceAppointments');
                Route::get('/appointment/doctor/List',[PatientController::class, 'doctorAppointmentList'])->name('patient.doctorAppointments');
                Route::get('/records',[PatientController::class, 'records'])->name('patient.records');
                Route::get('/consult/records/detail/{id}',[PatientController::class, 'viewConsultRecordDetail'])->name('patient.consultRecordDetail');
                Route::get('/password/change',[PatientController::class,'cAuhangePasswordPage'])->name('patient.changePassword');
                Route::post('/password/change',[PatientController::class,'changePassword'])->name('patient.passwordChange');

            });
        });




    });
});
Route::middleware('doctor')->group(function(){

    Route::prefix('/doctor')->group(function(){
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/profile', [DoctorController::class, 'doctorProfile'])->name('doctor.profile');
    Route::post('/logout',[AuthController::class, 'doctorLogout'])->name('doctor.logout');
    Route::post('/profile/edit', [DoctorController::class,'doctorProfileEdit'])->name('doctor.profileEdit');
    Route::get('/appointments', [DoctorController::class,'doctorDashboardAppointment'])->name('doctor.appointmentDashboard');
    Route::get('/appointments/new',[DoctorController::class, 'newAppointment'] )->name('doctor.newAppointments');
    Route::get('/records/upload/{id}',[DoctorController::class,'recordsUpload'])->name('doctor.recordsUpload');
    Route::post('/records/upload',[DoctorMedicalRecordsController::class,'postRecords'])->name('doctor.postRecords');
    Route::get('/records/{id}', [DoctorMedicalRecordsController::class,'uploadedRecords'])->name('doctor.records');
    Route::get('/appointments/consulted',[DoctorController::class,'consultedAppointments'])->name('doctor.consultedAppointments');
    Route::get('/appointments/cancelled',[DoctorController::class,'cancelledAppointments'])->name('doctor.cancelledAppointments');
    Route::get('/appointments/missed',[DoctorController::class,'missedAppointments'])->name('doctor.missedAppointments');
    });



});
