@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Admin Profile')

@if (session('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="col-md-9 offset-2">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Clinic Information</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form class="row g-3 m-1">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputEmail4" value="{{ $admin->name }}">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Email</label>
                <input type="tel" class="form-control" id="inputPassword4" value="{{ $admin->email }}">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" value="{{ $admin->address }}">
            </div>
            <div class="col-md-6">
                <label for="inputAddress2" class="form-label">Phone1</label>
                <input type="text" class="form-control" id="inputAddress2" value="{{ $admin->phone1 }}">
            </div>

            <div class="col-md-6">
                <label for="inputAddress2" class="form-label">Phone 2</label>
                <input type="text" class="form-control" id="inputAddress2" value="{{ $admin->phone2 }}">
            </div>

            <div class="col mb-3 align-content-center">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-key mr-1"></i>Update
                    Password</button>
                <button type="submit" class="btn btn-primary"><i class="fa-regular fa-id-badge mr-1"></i>Update
                    Profile</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>
@endsection
