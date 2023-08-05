<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\ClinicAdminsController;
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


Route::middleware(['auth',])->group(function () {

    Route::middleware(['super_admin'])->group(function () {
        Route::get('/', function () {
            return view('master');
        });
        Route::prefix('superadmin/clinics')->group(function () {

            Route::get('/form', [SuperAdminController::class, 'registerClinic'])->name('superAdmin.clinic');
            Route::post('/register', [SuperAdminController::class, 'Clinic'])->name('clinic.register');
            Route::get('/list', [SuperAdminController::class, 'clinicList'])->name('clinic.list');
            Route::get('/edit/{id}', [SuperAdminController::class, 'editForm'])->name('clinic.editForm');
            Route::post('/edit', [SuperAdminController::class, 'editClinic'])->name('clinic.edit');
            Route::get('/deactivate', [SuperAdminController::class, 'deactivateClinic'])->name('clinic.deactivate');

            Route::prefix('/admins')->group(function () {
                Route::get('/admins', [ClinicAdminsController::class, 'admin'])->name('admin.list');
                Route::get('/admins/register', [ClinicAdminsController::class, 'registerAdmin'])->name(('admin.registerForm'));
                Route::post('/admins/register', [ClinicAdminsController::class, 'createAdmin'])->name(('admin.register'));
            });

            Route::prefix('/specialty')->group(function () {
                Route::get('/specialties', [SpecialtyController::class, 'specialty'])->name('specialty.list');
                Route::post('/specialties/register', [SpecialtyController::class, 'createSpecialty'])->name(('specialty.register'));
            });

            Route::prefix('/serviceCategory')->group(function () {
                Route::get('/services', [ServiceCategoryController::class, 'serviceCategory'])->name('serviceCategory.list');
                Route::post('/services/register', [ServiceCategoryController::class, 'createServiceCategory'])->name(('serviceCategory.register'));
            });
        });
    });
    Route::middleware(['admin'])->group(function () {
        Route::get('/', [AdminController::class, 'profile'])->name('admin.clinicProfile');
        Route::prefix('/admin')->group(function () {
            Route::get('/doctorList', [AdminController::class, 'doctorList'])->name('admin.doctorList');
            Route::get('/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
            Route::get('/specialty', [AdminController::class, 'specialty'])->name('admin.specialty');
        });
    });
});
