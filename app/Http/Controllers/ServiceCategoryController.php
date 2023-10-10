<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Storage;

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
        $filename = uniqid() . $request->file('serviceImage')->getClientOriginalName();
        $request->file('serviceImage')->storeAs('public/', $filename);
        $data['photo']=$filename;
        ServiceCategory::create($data);
        return redirect()->route('serviceCategory.list')->with(['message' => 'Service Category created successfully']);
    }
    //direct to edit form
    public function editForm($id){
        $category= ServiceCategory::where('id', $id)->first();
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
            'photo' => $request->serviceImage

        ];
    }
}
