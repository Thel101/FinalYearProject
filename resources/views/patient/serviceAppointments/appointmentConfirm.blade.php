@extends('patient.master');
@section('title', 'Appointment Confirmation Page')
@section('template')

<div>
    @if (isset($appointmentSuccessMessage))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ $appointmentSuccessMessage}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<div class="card col-lg-9 col-md-6 offset-lg-2">

    <div class="card-body">
      <h4 class="card-title text-info font-bold">This is your appointment Details</h4>

      <div class="offset-lg-1 p-2">
        <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead">Service : {{$serviceInfo->name}}</span></div>

        <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead">Clinic : {{$clinicInfo->name}}</span></div>
        <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead">Location : {{$clinicInfo->address}} ,{{$clinicInfo->township}}</span></div>
      </div>



        <div class="row mt-3 offset-lg-1">
            <div class="col-lg-3 col-md-3">
                <p class="card-text lead">Patient Name : </p>
                <p class="card-text lead">Appointment Date</p>
                <p class="card-text lead">Appointment Time</p>
                <p class="card-text lead">Fees</p>
                <p class="card-text lead">Discount</p>
                <p class="card-text lead">Total Fees</p>
            </div>
            <div class="col-lg-6 col-md-6">
                <p class="card-text lead">{{$serviceAppointmentInfo->patient_name}}</p>
                <p class="card-text lead">{{$serviceAppointmentInfo->appointment_date}}</p>
                <p class="card-text lead">{{$serviceAppointmentInfo->time_slot}}</p>
                <p class="card-text lead">{{$serviceAppointmentInfo->fees}} MMK</p>
                <p class="card-text lead">{{$serviceAppointmentInfo->discount}} %</p>
                <p class="card-text lead">{{$serviceAppointmentInfo->total_fees}} MMK</p>
            </div>
        </div>

      <div class="row">
        <div class="col-4">


        </div>
        <div class="col-6"></div>
      </div>

      <div class="row offset-1">
        <div class="col-lg-3">
            <a href="{{route('patient.home')}}" class="mt-2 btn btn-primary"><i class="fa-solid fa-circle-left m-1"></i>Back to home page</a>
        </div>
        <div class="col-lg-4">
            <a href="{{route('patient.profile')}}" class="mt-2 btn btn-primary">See detail in dashboard</a>
        </div>

      </div>

    </div>
  </div>
@endsection
@section('scriptSource')

@endsection
