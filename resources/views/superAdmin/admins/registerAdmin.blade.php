@extends('master')
@section('title', 'Register Admin')
@section('content')
@section('pageTitle', 'Register Clinic Admin')

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
            <h3 class="card-title">Clinic Admin Information</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="{{ route('admin.register') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="adminName">Admin name</label>
                    <input type="text" name="adminName" class="form-control @error('adminName') is-invalid @enderror" id="name"
                        placeholder="Enter admin name" value="{{old('adminName')}}">
                        @error('adminName')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                </div>
                <div class="form-group">
                    <label for="adminEmail">Email address</label>
                    <input type="email" name="adminEmail" class="form-control @error('adminEmail') is-invalid @enderror" id="email"
                        placeholder="Enter email address" value="{{old('adminEmail')}}">
                        @error('adminEmail')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                </div>

                <div class="form-group" id="PhoneNumber">
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone1" class="form-control @error('phone1') is-invalid @enderror" id="phone"
                        placeholder="Enter admin phone number" value="{{old('phone1')}}">
                        @error('phone1')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    <span><button type="button" id="addNewPhone" class="btn btn-secondary btn-sm m-1"
                            title="Add New Phone"><i class="fa-solid fa-plus"></i></button></span>
                </div>
                <div class="form-group" id="PhoneNumber2">
                    <label for="phone">Phone Number 2</label>
                    <input type="tel" name="phone2" class="form-control @error('phone2') is-invalid @enderror" id="phone"
                        placeholder="Enter admin phone number" value="{{old('phone2')}}">
                        @error('phone2')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror

                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" >
                        <option value="">Choose Role</option>
                        <option value="admin" {{old('role') == 'admin' ? 'selected' : ''}}>Admin</option>
                        <option value="clinic admin"{{old('role') == 'clinic admin' ? 'selected' : ''}}>Clinic Admin</option>
                        <option value="clinic staff" {{old('role') == 'clinic staff' ? 'selected' : ''}}>Clinic Staff</option>
                    </select>
                        @error('role')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                </div>

                <div class="form-group">
                    <label>Responsible Clinic</label>
                    <select class="form-select @error('clinic') is-invalid @enderror" aria-label="Default select example" name="clinic">
                        <option value="0">Choose Clinic</option>
                        @foreach ($clinics as $c)
                            <option value="{{ $c->id }}" {{old('clinic') == $c->id ? 'selected' : ''}}>{{ $c->name }}</option>
                        @endforeach

                    </select>
                    @error('clinic')
                        <div class="invalid-feedback">{{message}}</div>
                    @enderror
                </div>


            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary offset-4 col-4">Add Admin</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>

@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {

        $('#PhoneNumber2').hide();
        $section = $('#PhoneNumber2');
        $('#addNewPhone').click(function() {
            $('#PhoneNumber2').toggle();


        });
    })
</script>
@endsection
