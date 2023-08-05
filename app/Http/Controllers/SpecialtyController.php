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
    //format clinic data
    private function formatSpecialtyInfo(Request $request)
    {
        return [
            'name' => $request->specialtyName,

        ];
    }
}
