<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function dashboard()
    {
        // dd(Auth::user()->role);

        if (Auth::user()->role == 'admin') {
            return redirect()->route('superAdmin.clinic');
        }
        else if(Auth::user()->role == 'clinic admin') {
            return redirect()->route('admin.clinicProfile');
        }
        else if(Auth::user()->role == 'user') {
            return redirect()->route('patient.profile');
        }
        else{
            return redirect()->route('login');
        }

    }
    public function loginForm(){
        return view('patient.doctorLogin');
    }
    public function doctorLogin(Request $request){
        $credentials = $request->only('email', 'password');
    }

}
