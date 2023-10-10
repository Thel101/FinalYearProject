<?php

namespace App\Http\Controllers\Admin;

use session;
use App\Models\User;
use App\Models\Doctors;
use App\Models\Services;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Profiler\Profile;

class AdminController extends Controller
{
    //clinic profile
    public function profile()
    {
        $clinic = $this->clinicInfo();
        return view('admin.clinicProfile', compact('clinic'));
    }

    //admin profile
    public function adminProfile()
    {
        $clinic = $this->clinicInfo();
        $admin = User::where('id', Auth::user()->id)->first();
        return view('admin.adminProfile', compact('admin', 'clinic'));
    }



    //service list
    public function serviceList()
    {

        $clinicId = Auth::user()->clinic_id;
        $clinic = $this->clinicInfo();
        $services = Services::select('services.*', 'service_categories.name as category_name')
            ->leftJoin('service_categories', 'service_categories.id', 'services.category_id')
            ->where('services.clinic_id', $clinicId)
            ->get();
        return view('admin.serviceList', compact('services', 'clinic'));
    }
    //service register form
    public function registerFormService()
    {
        $clinic = $this->clinicInfo();
        $category = ServiceCategory::get();
        return view('admin.registerService', compact('clinic', 'category'));
    }
    //register service
    public function registeService(Request $request)
    {
        $data = $this->formatServiceInfo($request);
        $filename = uniqid() . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('public/', $filename);
        $data['photo'] = $filename;
        $data['available_token_count']= "10";
        Services::create($data);
        return redirect()->route('admin.serviceList')->with(['message' => 'Service Registered Successfully']);
    }


    //retrieve clinic info
    private function clinicInfo()
    {
        return User::select('users.*', 'clinics.*', 'clinics.name as clinic_name', 'clinics.phone as clinic_phone')
            ->where('users.id', Auth::user()->id)
            ->leftJoin('clinics', 'users.clinic_id', 'clinics.id')->first();
    }

    private function formatServiceInfo(Request $request)
    {
        return [
            'name' => $request->name,
            'photo' => $request->photo,
            'category_id' => $request->category,
            'clinic_id' => Auth::user()->clinic_id,
            'description' => $request->description,
            'components' => $request->input('components', []),
            'price' => $request->price,
            'promotion_rate' => $request->rate,
            'promotion' => $request->promotion
        ];
    }
}
