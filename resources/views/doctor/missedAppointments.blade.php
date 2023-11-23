@extends('doctor.appointmentTableTemplate')
@section('section')
@section('cancelledAppointmentTable')
    @if (count($missed_appointments) == 0)
        <div class="card-body">
            <div>
                <h5 class="text-danger text-center">There is no booked appointments yet!</h5>
            </div>
        </div>
    @else
        <h4 class="my-2">Cancelled Appointments</h4>
        <table id="doctorAppointmentTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Appointment Date & Time</th>
                    <th>Patient</th>
                    <th>Status</th>


                </tr>
            </thead>
            <tbody>

                @foreach ($missed_appointments as $a)
                    <tr>
                        <td> <p>{{ $a->appointment_date }}</p>
                            <p>{{ $a->time_slot }}</p></td>

                        <td>
                            <div class="lh-lg">Name: <span class="text-bold">{{ $a->patient_name }}</span></div>
                            <div class="lh-lg">Age :<span class="text-bold">{{ $a->patient_age }}</span></div>
                            <div class="lh-lg">Symptoms :<span class="text-bold">{{ $a->symptoms }}</span></div>
                        </td>
                        <td> <span class="badge badge-danger">{{$a->status}}</span></td>

                    </tr>
                @endforeach
            </tbody>

        </table>
    @endsection
@endif
@endsection
@section('scriptSource')
@endsection
