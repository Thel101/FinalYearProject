<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinics;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    //dashboard
    public function adminProfile(){
        return view('superAdmin.profile');
    }
    //register page
    public function registerClinic()
    {
        return view('superAdmin.registerClinic');
    }
    //register function
    public function Clinic(Request $request)
    {
        $data = $this->formatClinicData($request);
        Clinics::create($data);
        return redirect()->route('clinic.list')->with(['success' => 'Clinic has been successfully created']);
    }

    //clinic list
    public function clinicList()
    {
        $clinics = Clinics::get();
        return view('superAdmin.clinicList', compact('clinics'));
    }

    //direct to edit form
    public function editForm($id)
    {
        $clinic = Clinics::where('id', $id)->first();
        return response()->json([
            'status' => 'success',
            'clinic_data' => $clinic,
        ]);
    }
    //edit function
    public function editClinic(Request $request)
    {
        $clinicId = $request->clinicId;
        $data = $this->formatClinicData($request);
        Clinics::where('id', $clinicId)->update($data);
        return redirect()->route('clinic.list')->with(['EditSuccess' => 'Clinic has been successfully updated']);
    }
    //deatviate clinic
    public function deactivateClinic(Request $request)
    {
        $id = $request->clinicId;
        $inactiveClinic = Clinics::where('id', $id)->first();
        if ($inactiveClinic->status == 1) {
            $inactiveClinic->status = 0;
            $inactiveClinic->save();
        } else {
            $inactiveClinic->status = 1;
            $inactiveClinic->save();
        };

        return redirect()->route('clinic.list')->with(['DeactivateSuccess' => 'Clinic status has been successfully updated']);
    }
    private function formatClinicData(Request $request)
    {
        return [
            'name' => $request->clinicName,
            'address' => $request->clinicAddress,
            'township' => $request->clinicTownship,
            'phone' => $request->clinicPhone,
            'opening_hour' => $request->openingHour,
            'closing_hour' => $request->closingHour
        ];
    }
}
