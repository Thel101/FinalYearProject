<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function serviceCategory()
    {
        $services = ServiceCategory::get();
        return view('superAdmin.serviceCategoryList', compact('services'));
    }
    //direct to register page


    public function createServiceCategory(Request $request)
    {
        $data = $this->formatServiceInfo($request);
        ServiceCategory::create($data);
        return redirect()->route('serviceCategory.list')->with(['message' => 'Service Category created successfully']);
    }
    //format clinic data
    private function formatServiceInfo(Request $request)
    {
        return [
            'name' => $request->serviceName,
            'type' => $request->type

        ];
    }
}
