<?php

namespace App\Http\Controllers;

use App\Models\ClinicAdmins;
use App\Models\Clinics;
use Illuminate\Http\Request;

class ClinicAdminsController extends Controller
{
    public function admin()
    {
        return view('superAdmin.adminList');
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
        ClinicAdmins::create($data);
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
            'clinic_id' => $request->clinic
        ];
    }
}
