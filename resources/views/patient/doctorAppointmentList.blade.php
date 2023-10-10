@extends('patient.profile')
@section('content')
@section('pageTitle', 'Clinic Available Services')

<div class="card">
<div class="card-header">
    <h3 class="card-title">My Doctor Appointments</h3>
</div>
<!-- /.card-header -->


@if (count($appointments) == 0)
    <div class="card-body">
        <div>
            <h5 class="text-danger text-center">There is no booked appointments yet!</h5>
        </div>
    </div>
@else
    <div class="card-body">
        <table id="doctorAppointmentTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>App_id</th>
                    <th>Appointment Details</th>
                    <th>Patient Details</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                @foreach ($appointments as $a)
                    <tr>

                        <td>{{$a->id}}</td>
                        <td>
                            <div class="lh-lg">DR.{{ $a->doctor_name }}</div>
                            <div class="lh-lg">{{$a->specialty_name}}</div>
                            <div class="lh-lg">{{$a->appointment_date}}</div>
                            <div class="lh-lg">{{$a->time_slot}}</div>
                        </td>

                        <td>
                            <div class="lh-lg">{{ $a->patient_name }}</div>
                            <div class="lh-lg">{{$a->patient_age}}</div>
                            <div class="lh-lg">{{$a->phone_1}}</div>
                            <div class="lh-lg">{{$a->phone_2}}</div>
                        </td>

                        <td>
                            <a class="btn btn-sm btn-success updBtn" href="{{route('doctor.appointmentConfirm', $a->id)}}" title="download booking"><i class="fa-solid fa-file-arrow-down"></i></a>
                            <a class="btn btn-sm btn-secondary updBtn" href="#" title="view detail"><i class="fa-regular fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@endif
</tbody>

</table>


<!-- /.card-body -->
</div>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function(){
        $('#doctorAppointmentTable').dataTable({
            "autoWidth" : false,
            "columns": [
                { "width": "10%" },
                null, // automatically calculates
                null,
                {"width": "5%"} // remaining width
            ]
        });
    })
</script>
@endsection
