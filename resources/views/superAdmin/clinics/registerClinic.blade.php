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
        <form action="{{ route('clinic.register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Clinic name</label>
                    <input type="text" name="clinicName" class="form-control  @error('clinicName') is-invalid @enderror" id="name"
                        placeholder="Enter clinic name" value="{{old('clinicName')}}">
                        <div class="invalid-feedback">
                            @error('clinicName')
                                {{$message}}
                            @enderror
                        </div>
                </div>


                <div class="form-group">
                    <label for="address">Clinic address</label>
                    <input type="text" name="clinicAddress" class="form-control @error('clinicAddress') is-invalid @enderror" id="address"
                        placeholder="No(6)/ Street/ Wardp" value="{{old('clinicAddress')}}">
                        @error('clinicAddress')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                </div>


                <div class="form-group">
                    <label for="township">Clinic township</label>
                    <input type="text" name="clinicTownship" class="form-control @error('clinicTownship') is-invalid @enderror" id="address"
                        placeholder="Enter clinic townshp" value="{{old('clinicTownship')}}">
                        @error('clinicTownship')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                </div>


                <div class="form-group">
                    <label for="phone">Clinic phone</label>
                    <input type="text" name="clinicPhone" class="form-control @error('clinicPhone') is-invalid @enderror" id="phone"
                        placeholder="Enter phone number e.g. 095004283" value="{{old(
                            'clinicPhone'
                        )}}">
                        @error('clinicPhone')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                </div>


                <div class="form-group">
                    <label for="photo">Clinic Photo</label>
                    <input type="file" name="clinicPhoto" class="form-control @error('clinicPhoto') is-invalid @enderror" id="photo">
                        @error('clinicPhoto')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="opening">Clinic opening hour</label>
                    <input type="time" class="form-control @error('openingHour') is-invalid @enderror" id="opening" name="openingHour" value="{{old('openingHour'

                    )}}">
                    @error('openingHour')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="closing">Clinic closing hour</label>
                    <input type="time" class="form-control @error('closingHour') is-invalid @enderror" id="closing" name="closingHour" value="{{old('closingHour'

                    )}}">
                    @error('closingHour')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
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
