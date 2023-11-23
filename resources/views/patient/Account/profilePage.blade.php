@extends('patient.Account.profile')
@section('content')
@section('pageTitle', 'Patient Profile Page')
<head>
    <style>
        .card{border:none}.image{position:relative}.image span{background-color:blue;color:#fff;padding:6px;height:30px;width:30px;border-radius:50%;font-size:13px;position:absolute;display:flex;justify-content:center;align-items:center;top:-0px;right:0px}.user-details h4{color:blue}.ratings{font-size:30px;font-weight:600;display:flex;justify-content:left;align-items:center;color:#f9b43a}.user-details span{text-align:left}.inputs label{display:flex;margin-left:3px;font-weight:500;font-size:15px;margin-bottom:4px}.inputs input{font-size:14px;height:40px;border:2px solid #ced4da}.inputs input:focus{box-shadow:none;border:2px solid blue}.about-inputs label{display:flex;margin-left:3px;font-weight:500;font-size:13px;margin-bottom:4px}.about-inputs textarea{font-size:14px;height:100px;border:2px solid #ced4da;resize:none}.about-inputs textarea:focus{box-shadow:none}.btn{font-weight:600}.btn:focus{box-shadow:none}
    </style>
</head>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container mt-3">
    <div class="card p-3 text-center">
        <div class="d-flex flex-row justify-content-center mb-3">
            <div class="image">
                @if (Auth::user()->profile_photo_path!=null)
                <img src="{{asset('storage/'. $user->profile_photo_path)}}" style="width: 100px; height:100px" class="rounded-circle">
                @else
                <img src="https://assets.stickpng.com/images/585e4bcdcb11b227491c3396.png" style="width: 100px; height:100px" class="img-thumbnail rounded-circle">
            @endif
                 </div>
            <div class="d-flex flex-column ms-3 user-details">
                <h4 class="mb-0">Zenda Grace</h4>
                <div class="ratings"> <span>4.0</span> <i class='bx bx-star ms-1'></i> </div> <span>Pro Member</span>
            </div>
        </div>
        <h4>Edit Profile</h4>
        <form action="{{route('patient.updateProfile')}}" method="POST" enctype="multipart/form-data">
            @csrf
        <div>
            <div class="row">
                <div class="col-md-6 my-2">
                    <div class="inputs"> <label>Name</label> <input class="form-control" type="text" name="updateName" value="{{$user->name}}"> </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="inputs"> <label>Email</label> <input class="form-control" type="text" name="updateEmail" value="{{$user->email}}"> </div>
                </div>
                <div class="col-md-3 my-2">
                    <div class="inputs"> <label>Phone 1</label> <input class="form-control" type="text" name="updatePhone1" value="{{$user->phone1}}"> </div>
                </div>
                <div class="col-md-3 my-2">
                    <div class="inputs"> <label>Phone 2</label> <input class="form-control" type="text" name="updatePhone2" value="{{$user->phone2}}"> </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="inputs"> <label>Photo</label> <input class="form-control" name="profilePhoto" type="file"> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="about-inputs"> <label>Address</label> <textarea class="form-control" name="updateAddress" type="text">{{$user->address}} </textarea> </div>
                </div>
            </div>
            <div class="mt-3 gap-2 d-flex justify-content-end">
                <button class="px-3 btn btn-sm btn-outline-primary">Cancel</button>
                <button type="submit" class="px-3 btn btn-sm btn-primary">Update</button> </div>
        </div>

    </div>
</div>
@endsection
