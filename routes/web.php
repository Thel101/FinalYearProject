<?php

use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\ClinicAdminsController;
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
    Route::get('/admins', [ClinicAdminsController::class, 'admin'])->name('admin.list');
    Route::get('/admins/register', [ClinicAdminsController::class, 'registerAdmin'])->name(('admin.registerForm'));
    Route::post('/admins/register', [ClinicAdminsController::class, 'createAdmin'])->name(('admin.register'));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
