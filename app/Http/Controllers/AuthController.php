<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
            return redirect()->route('patient.profileDetails');
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
        $email = $credentials['email'];

        $password = $credentials['password'];
        // dd([$email,$password]);
        $doctor=Doctors::where('email',$email)->first();
        $image = $doctor->photo;
        if($doctor && Hash::check($password, $doctor->password)){
            Session::put('email', $email);
            Session::put('image', $image);

            return redirect()->route('doctor.profile');
        }
        else{
            return redirect()->route('doctor.loginForm')->with(['error'=> 'Doctor Authentication failed!']);
        }

    }
    public function doctorLogout(){
        Session::flush();
        return redirect()->route('patient.home');
    }

}
