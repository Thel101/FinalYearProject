@extends('admin.services.serviceAppointmentTemplate')
@section('recorded')
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
                        @if (isset($records[$sa->id]))
                        @foreach ($records[$sa->id] as $record)
                        <a class="btn btn-primary"
                        href="{{ url(Storage::url($record->result_file)) }}" title="View Result"><i class="fa-regular fa-eye"></i></a>
                        @endforeach
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endsection
