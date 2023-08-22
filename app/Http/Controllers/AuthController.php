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
        } else {
            return redirect()->route('admin.clinicProfile');
        }
    }
}
