<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Clinics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Doctors;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //clinic profile
    public function profile()
    {
        $clinic = User::select('users.*', 'clinics.*', 'clinics.name as clinic_name', 'clinics.phone as clinic_phone')
            ->where('users.id', Auth::user()->id)
            ->leftJoin('clinics', 'users.clinic_id', 'clinics.id')->first();

        return view('admin.clinicProfile', compact('clinic'));
    }

    //admin profile
    public function adminProfile()
    {
        $clinic = User::select('users.*', 'clinics.name as clinic_name')
            ->where('users.id', Auth::user()->id)
            ->leftJoin('clinics', 'users.clinic_id', 'clinics.id')->first();
        $admin = User::where('id', Auth::user()->id)->first();
        return view('admin.adminProfile', compact('admin', 'clinic'));
    }
    //doctor list
    public function doctorList()
    {
        $doctor = Doctors::where('')
    }
    public function specialty()
    {
        return view('admin.specialty');
    }
}
