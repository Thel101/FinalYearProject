@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Clinic Profile')

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
        <form class="row g-3 m-1" action="" method="">
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="clinicName" id="name" value="{{ $clinic->clinic_name }}">
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" name="clinicPhon" ="phone" value="{{ $clinic->clinic_phone }}">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" value="{{ $clinic->address }}">
            </div>
            <div class="col-md-6">
                <label for="inputAddress2" class="form-label">Township</label>
                <input type="text" class="form-control" id="inputAddress2" value="{{ $clinic->township }}">
            </div>

            <div class="col-md-6">
                <label for="inputAddress2" class="form-label">Email Address</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="clinic@gmail.com">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">Opening Hour</label>
                <input type="text" class="form-control" value="{{ $clinic->opening_hour }}" id="inputCity">
            </div>

            <div class="col-md-6">
                <label for="inputZip" class="form-label">Closing Hour</label>
                <input type="text" class="form-control" value="{{ $clinic->closing_hour }}" id="inputZip">
            </div>

            <div class="col-12 my-3">
                <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>
@endsection
