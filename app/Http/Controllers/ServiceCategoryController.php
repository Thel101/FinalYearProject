<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
{
    public function serviceCategory()
    {
        $services = ServiceCategory::get();
        return view('superAdmin.services.serviceCategoryList', compact('services'));
    }
    //direct to register page
    public function createServiceCategory(Request $request)
    {
        $this->validateServiceInfo($request);
        $data = $this->formatServiceInfo($request);
        if($request->hasFile('serviceImage')){
        $filename = uniqid() . $request->file('serviceImage')->getClientOriginalName();
        $request->file('serviceImage')->storeAs('public/', $filename);
        $data['photo']=$filename;
        }
        ServiceCategory::create($data);
        return redirect()->route('serviceCategory.list')->with(['message' => 'Service Category created successfully']);
    }
    public function duplicateCategory(Request $request){
        $serviceName=$request->serviceName;
        $serviceCategory = ServiceCategory::where('name',$serviceName)->first();
        if($serviceCategory){
            return response()->json(['message'=> 'Service Category already exists']);
        }
    }
    //direct to edit form
    public function editForm($id){

        $category= ServiceCategory::where('id', $id)->first();
        logger($category->name);
        return response()->json([
            'status' => 'success',
            'category_data' => $category
        ]);
    }
    public function edit(Request $request){
        $id= $request->serviceId;
        $data= $this->formatServiceInfo($request);
        if($request->hasFile('serviceImage')){
            $oldImage = ServiceCategory::where('id', $id)->first();
            $dbImage = $oldImage->photo;
            if($dbImage!==null){
                Storage::delete('public/'. $dbImage);
            }
            $filename = uniqid(). $request->file('serviceImage')->getClientOriginalName();
            $request->file('serviceImage')->storeAs('public/' , $filename);
            $data['photo'] = $filename;
        }
        ServiceCategory::where('id', $id)->update($data);
        return redirect()->route('serviceCategory.list')->with(['editSuccess' => 'Service Category updated successfully']);

    }
    //format clinic data
    private function formatServiceInfo(Request $request)
    {
        return [
            'name' => $request->serviceName,
        ];
    }
    private function validateServiceInfo(Request $request){
        $validationRules=[
            'serviceName'=> 'required|min:5|unique:service_categories,name',

        ];
        Validator::make($request->all(),$validationRules)->validate();

    }
}
