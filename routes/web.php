<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicAdminsController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PatientController;
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
Route::get('/doctor/login',[AuthController::class, 'loginForm'])->name('doctor.loginForm');
Route::post('/doctor/login',[AuthController::class, 'doctorLogin'])->name('doctor.login');
// Route::get('/login', [AuthController::class, 'login'])->name('login');
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
            });
        });
    });
    Route::middleware(['admin'])->group(function () {
        Route::get('/clinic/profile', [AdminController::class, 'profile'])->name('admin.clinicProfile');
        Route::prefix('/admin')->group(function () {
            Route::get('/doctorList', [DoctorController::class, 'doctorList'])->name('admin.doctorList');
            Route::get('/doctor', [DoctorController::class, 'registerForm'])->name('admin.doctorForm');
            Route::post('/doctor/register', [DoctorController::class, 'registerDoctor'])->name('admin.doctorRegister');
            Route::post('/doctor/add', [DoctorController::class, 'addDoctor'])->name('admin.addDoctor');
            Route::get('/doctor/edit/{id}', [DoctorController::class, 'editDoctor'])->name('admin.editDoctor');
            Route::post('/doctor/edit',[DoctorController::class, 'doctorEdit'])->name('adminDoctor.edit');
            Route::get('/doctor/remove', [DoctorController::class, 'removeDoctor'])->name('admin.doctorRemove');
            Route::get('/doctor/detail/{id}',[DoctorController::class, 'doctorDetail'])->name('admin.doctorDetail');
            Route::get('/doctors/schedules/list',[DoctorController::class, 'doctorSchedules'])->name('doctors.schedules');
            Route::get('/schedulesForm/{id}', [DoctorController::class, 'scheduleForm'])->name('admin.docSchedules');
            Route::post('/schedules/add', [DoctorController::class, 'addSchedules'])->name('admin.addSchedules');
            Route::get('/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
            Route::get('/specialty', [AdminController::class, 'specialty'])->name('admin.specialty');
            Route::get('/serviceList', [AdminController::class, 'serviceList'])->name('admin.serviceList');
            Route::get('/service', [AdminController::class, 'registerFormService'])->name('admin.serviceForm');
            Route::post('/service/register', [AdminController::class, 'registeService'])->name('admin.serviceRegister');



        });
    });
    Route::middleware(['patient'])->group(function(){
        Route::prefix('/patient')->group(function(){
            Route::get('/profile',[PatientController::class, 'profile'])->name('patient.profile');
            //service appointment routes
            Route::get('/service/appointment/{id}',[AppointmentController::class, 'appointmentPage'])->name('patient.appointment');
            Route::post('/appointment', [AppointmentController::class, 'serviceAppointment'])->name('service.appointment');
            Route::get('/date/appointment', [AppointmentController::class, 'appointmentDate'])->name('service.appointmentDate');
            //doctor appointment routes
            Route::prefix('/doctors')->group(function(){
                Route::get('/appointment/page/{id}',[DoctorAppointmentController::class, 'docAppointmentPage'])->name('patient.docAppointmentPage');
                Route::get('/availability',[DoctorAppointmentController::class, 'doctorAvailability']);
                Route::post('/appointment', [DoctorAppointmentController::class, 'doctorAppointment'])->name('doctor.appointment');
                Route::get('/appointment/download/{id}',[DoctorAppointmentController::class, 'generatePDF'])->name('doctor.appointmentConfirm');
                Route::get('/appointment/email', [MailController::class, 'confirmEmail'])->name('doctorAppointment.email');

            });
            Route::prefix('/dashboard')->group(function(){
                Route::get('/profile',[PatientController::class, 'profileDetails'])->name('patient.profileDetails');
                Route::get('/appointment/service/List',[PatientController::class, 'serviceAppointmentList'])->name('patient.serviceAppointments');
                Route::get('/appointment/doctor/List',[PatientController::class, 'doctorAppointmentList'])->name('patient.doctorAppointments');
                Route::get('/records',[PatientController::class, 'records'])->name('patient.records');
            });
        });




    });
});
