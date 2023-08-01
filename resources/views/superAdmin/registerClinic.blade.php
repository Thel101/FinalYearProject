@extends('master')
@section('title', 'Register Clinic')
@section('content')
@section('pageTitle', 'Register Clinic')

@if (session('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="col-md-6 offset-3">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Clinic Information</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="{{ route('clinic.register') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Clinic name</label>
                    <input type="text" name="clinicName" class="form-control" id="name"
                        placeholder="Enter clinic name">
                </div>
                <div class="form-group">
                    <label for="address">Clinic address</label>
                    <input type="text" name="clinicAddress" class="form-control" id="address"
                        placeholder="No(6)/ Street/ Wardp">
                </div>

                <div class="form-group">
                    <label for="township">Clinic township</label>
                    <input type="text" name="clinicTownship" class="form-control" id="address"
                        placeholder="Enter clinic townshp">
                </div>
                <div class="form-group">
                    <label for="phone">Clinic phone</label>
                    <input type="text" name="clinicPhone" class="form-control" id="phone"
                        placeholder="Enter clinic phone">
                </div>
                <div class="form-group">
                    <label for="opening">Clinic opening hour</label>
                    <input type="time" class="form-control" id="opening" name="openingHour">
                </div>
                <div class="form-group">
                    <label for="closing">Clinic closing hour</label>
                    <input type="time" class="form-control" id="closing" name="closingHour">
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary offset-4 col-4">Add Clinic</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>

@endsection
