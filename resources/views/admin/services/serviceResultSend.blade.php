@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Service Results')


@if (session('EditSuccess'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('EditSuccess') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div class="col-12">

    <div class="card">
        <!-- /.card-body -->
        <div class="card-body">
            <form method="POST" action="{{ route('admin.sendResults') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="apptID" class="col-sm-2 col-form-label">Appointment ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="apptID" name="appointmentID"
                            value="{{ $serviceAppointment->id }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="service" class="col-sm-2 col-form-label">Service</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="service" name="service"
                            value="{{ $serviceAppointment->service_name }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Appointment Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="date"
                            value="{{ \Carbon\Carbon::parse($serviceAppointment->appointment_date)->format('Y-m-d') }}" name="appointmentDate"
                            readonly>
                    </div>
                </div>
                <input type="hidden" name="patientID" value="{{$serviceAppointment->patient_id}}">
                <div class="form-group row">
                    <label for="patient" class="col-sm-2 col-form-label">Patient Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="patient" name="patientName"
                            value="{{ $serviceAppointment->patient_name }}" readonly>
                    </div>
                </div>

                <input type="hidden" name="patientID" value="{{$serviceAppointment->patient_id}}">

                <div class="form-group row">
                    <label for="patient" class="col-sm-2 col-form-label">Booking Person</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="patient"
                            value="{{ $bookingPerson->name }}" readonly>
                    </div>
                </div>
                <input type="hidden" name="email" value="{{$bookingPerson->email}}">
                <input type="hidden" name="bookingPerson" value="{{$bookingPerson->id}}">

                <div class="form-group row">
                    <label for="patientAge" class="col-sm-2 col-form-label">Age</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="patientAge"
                            value="{{ $serviceAppointment->patient_age }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="result" class="col-sm-2 col-form-label">Result</label>
                    <div class="col-sm-10">
                        <input type="file" name="medical_results" class="form-control" id="result">
                    </div>
                </div>
                <div class="form-group row d-block">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Send Result</button>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.card-body -->

    </div>

    <!-- /.card -->
    <!-- /.card -->



@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('#serviceAppointmentTable').DataTable({
                "autoWidth": false,
                "columns": [{
                        "width": "5%"
                    },
                    null, // automatically calculates
                    null,
                    null,
                    {
                        "width": "15%"
                    } // remaining width
                ]
            });

        });
    </script>
@endsection
