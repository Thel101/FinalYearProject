<?php

namespace App\Http\Controllers;

use App\Models\ClinicAdmins;
use App\Models\Clinics;
use App\Models\User;
use Illuminate\Http\Request;

class ClinicAdminsController extends Controller
{
    public function admin()
    {
        $admins = User::select('users.*', 'clinics.name as clinic_name')
            ->where('role', 'clinic admin')
            ->leftJoin('clinics', 'users.clinic_id', 'clinics.id')->get();

        return view('superAdmin.adminList', compact('admins'));
    }
    //direct to register page

    public function registerAdmin()
    {
        $clinics = Clinics::get();

        return view('superAdmin.registerAdmin', compact('clinics'));
    }
    public function createAdmin(Request $request)
    {
        $data = $this->formatAdminInfo($request);
        User::create($data);
        return redirect()->route('admin.list')->with(['message' => 'New Admin created successfully']);
    }
    //format clinic data
    private function formatAdminInfo(Request $request)
    {
        return [
            'name' => $request->adminName,
            'email' => $request->adminEmail,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'role' => $request->role,
            'clinic_id' => $request->clinic
        ];
    }
}
