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
        <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead">Doctor : {{$docInfo->name}}</span></div>

        <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead">Clinic : {{$clinicInfo->name}}</span></div>
        <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead">Location : {{$clinicInfo->address}} ,{{$clinicInfo->township}}</span></div>
      </div>



        <div class="row mt-3 offset-lg-1">
            <div class="col-lg-3 col-md-3">
                <p class="card-text lead">Patient Name : </p>
                <p class="card-text lead">Symptoms</p>
                <p class="card-text lead">Appointment Date</p>
                <p class="card-text lead">Appointment Time</p>
                <p class="card-text lead">Consultation Fees</p>
                <p class="card-text lead">Clinic Charges</p>
                <p class="card-text lead">Total Fees</p>

            </div>
            <div class="col-lg-6 col-md-6">
                <p id="name" class="card-text lead">{{$doctorAppointmentInfo->patient_name}}</p>
                <p id="symptoms" class="card-text lead">{{$doctorAppointmentInfo->symptoms}}</p>
                <p id="date" class="card-text lead">{{$date}}</p>
                <p id="time" class="card-text lead">{{$doctorAppointmentInfo->time_slot}}</p>
                <p id="doc_fees" class="card-text lead">{{$doctorAppointmentInfo->doctor_fees}} MMK</p>
                <p id="clinic_charge" class="card-text lead">{{$doctorAppointmentInfo->clinic_charges}} MMK</p>
                <p id="total_fees" class="card-text lead">{{$doctorAppointmentInfo->total_fees}} MMK</p>

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
            <a href="{{route('patient.doctorAppointments')}}" id="btnPDF" class="mt-2 btn btn-primary">See detail in profile dashboard</a>
        </div>

      </div>

    </div>
  </div>
@endsection
@section('scriptSource')
  <script>
    // $(document).ready(function(){
    //     $('#btnPDF').click(function(){
    //         var appointmentInfo= {
    //              name : $('#name').text(),
    //              symptoms : $('#symptoms').text(),
    //              date : $('#date').text(),
    //              time : $('#time').text(),
    //              doc_fees : $('#doc_fees').text(),
    //              clinic_charge : $('#clinic_charge').text(),
    //              total_fees : $('#total_fees').text()
    //         }
    //         console.log(appointmentInfo);
    //         $.ajax({
    //             type: "GET",
    //             url: "http://127.0.0.1:8000/patient/doctors/appointment/download",
    //             data: {
    //                 download_data : appointmentInfo
    //             },
    //             success: function (response) {

    //             }
    //         });

    //     })
    // })
  </script>
@endsection
