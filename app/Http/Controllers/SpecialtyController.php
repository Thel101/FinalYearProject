<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function specialty()
    {
        $specialties = Specialty::get();
        return view('superAdmin.specialtyList', compact('specialties'));
    }
    //direct to register page
    public function createSpecialty(Request $request)
    {
        $data = $this->formatSpecialtyInfo($request);
        Specialty::create($data);
        return redirect()->route('specialty.list')->with(['message' => 'Specialty created successfully']);
    }
    //direct to edit form
    public function editSpecialtyForm($id){
        $specialty = Specialty::where('id', $id)->first();
        return response()->json([
            'status' => 'success',
            'specialty_data' => $specialty
        ]);
    }
    //edit function
    public function editSpecialty(Request $request){
        $specialtyId= $request->specialtyId;
        $update =$this->formatSpecialtyInfo($request);
        Specialty::where('id', $specialtyId)->update($update);
        return redirect()->route('specialty.list')->with(['EditSuccess'=> 'Specialty successfully updated']);
    }
    //format clinic data
    private function formatSpecialtyInfo(Request $request)
    {
        return [
            'name' => $request->specialtyName,

        ];
    }
}
