@extends('admin.services.serviceAppointmentTemplate')
@section('missed')
    <table id="serviceAppointmentTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>App_id</th>
                <th>Appointment Details</th>
                <th>Patient Details</th>
                <th>Fees</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($appointments as $sa)
                <tr>

                    <td>SA-{{ $sa->id }}</td>
                    <td>
                        <div class="lh-lg lead">{{ $sa->service_name }}</div>
                        <div class="lh-lg">{{ $sa->specialty_name }}</div>
                        <div class="lh-lg">{{ $sa->appointment_date }}</div>
                        <div class="lh-lg">{{ $sa->time_slot }}</div>
                    </td>

                    <td>
                        <div class="lh-lg">{{ $sa->patient_name }}</div>
                        <div class="lh-lg">{{ $sa->patient_age }}</div>
                        <div class="lh-lg">{{ $sa->phone_1 }}</div>
                        <div class="lh-lg">{{ $sa->phone_2 }}</div>
                    </td>
                    <td>
                        <div class="lh-lg">{{ $sa->fees }} MMKs</div>
                        <div class="lh-lg">{{ $sa->discount }} %</div>
                        <div class="lh-lg text-bold">{{ $sa->total_fees }} MMK</div>

                    </td>

                    <td>
                        <span class="badge badge-danger">{{$sa->status}}</span>

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endsection
