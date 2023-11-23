@extends('doctor.appointmentTableTemplate')
@section('section')
@section('newAppointmentTable')
    @if (count($appointments) == 0)
        <div class="card-body">
            <div>
                <h5 class="text-danger text-center">There is no booked appointments yet!</h5>
            </div>
        </div>
    @else

            <h4 class="my-2">New Appointments</h4>
            <table id="doctorAppointmentTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Time</th>
                        <th>Patient</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($appointments as $a)
                        <tr>
                            <td> {{ $a->appointment_date }}</td>
                            <td>{{ $a->time_slot }}</td>
                            <td>
                                <div class="lh-lg">Name: {{ $a->patient_name }}</div>
                                <div class="lh-lg">Age :{{ $a->patient_age }}</div>
                            </td>

                            <td>
                                <a href="{{ route('doctor.recordsUpload', $a->id) }}"><button type="button"
                                        class="btn btn-sm btn-outline-success mt-1">See Patients</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        @endsection
    @endif
@endsection
@section('scriptSource')
@endsection
