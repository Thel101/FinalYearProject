<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('email')) {
            return redirect()->route('doctor.loginForm')->with('error', 'Doctor authentication failed: Missing credentials.');
        }

        $email = Session::get('email');
        return $next($request);
    }
}
