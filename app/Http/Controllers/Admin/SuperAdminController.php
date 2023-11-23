<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Clinics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    //Clinic
    //register page
    public function registerClinic()
    {
        return view('superAdmin.clinics.registerClinic');
    }
    //register function
    public function Clinic(Request $request)
    {
        $this->validateClinicData($request);
        $data = $this->formatClinicData($request);
        $filename = uniqid() . $request->file('clinicPhoto')->getClientOriginalName();
        $request->file('clinicPhoto')->storeAs('public/', $filename);
        $data['photo'] = $filename;
        Clinics::create($data);
        return redirect()->route('clinic.list')->with(['success' => 'Clinic has been successfully created']);
    }

    //clinic list
    public function clinicList()
    {
        $clinics = Clinics::get();
        return view('superAdmin.clinics.clinicList', compact('clinics'));
    }

    //direct to edit form
    public function editForm($id)
    {
        $clinic = Clinics::where('id', $id)->first();
        logger($clinic);
        return response()->json([
            'status' => 'suucess',
            'clinic_data' => $clinic,
        ]);
    }
    //edit function
    public function editClinic(Request $request)
    {
        $clinicId = $request->clinicId;
        // dd($request->toArray());
        $this->validateClinicData($request);
        $data = $this->formatClinicData($request);
        // dd($data);
        if($request->hasFile('clinicPhoto')){
            $oldImage = Clinics::where('id', $clinicId)->first();
            $dbImage = $oldImage->photo;
            if($dbImage!==null){
                Storage::delete('public/'. $dbImage);
            }
            $filename = uniqid(). $request->file('clinicPhoto')->getClientOriginalName();
            $request->file('clinicPhoto')->storeAs('public/' , $filename);
            $data['photo'] = $filename;
        }
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
    private function validateClinicData(Request $request){

        $validationRules =
        [
            'clinicName' => 'required|min:10',
            'clinicAddress' => 'required|min:10',
            'clinicTownship' => 'required|min:5',
            'clinicPhone' => 'required|numeric',
            'clinicPhoto'=>'mimes:jpeg,png,webp|image',
            'openingHour' => 'required',
            'closingHour' => 'required',

      ];
      $validator= Validator::make($request->all(),$validationRules);
      if ($validator->fails()) {
        // Log validation errors
        Log::error('Validation errors', $validator->errors()->toArray());

        // Redirect back with validation errors (for debugging purposes)
        return redirect()->back()->withErrors($validator)->withInput();
    }
    }
}
