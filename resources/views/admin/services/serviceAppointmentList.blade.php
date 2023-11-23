@extends('admin.services.serviceAppointmentTemplate')
@section('booked')
    @if (session('cancel_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('cancel_message') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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


                        <button type="button" class="btn btn-sm btn-danger cancelBtn" data-bs-toggle="modal"
                            data-bs-target="#confirmForm" value="{{ $sa->id }}" title="cancel appointment"><i
                                class="fa-solid fa-ban"></i></button>

                        <a class="btn btn-sm btn-primary sendBtn" href="{{ route('admin.serviceResults', $sa->id) }}"
                            title="send results"><i class="fa-solid fa-share-from-square"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="modal fade" id="confirmForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remove Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('admin.serviceAppointmentCancel') }}" method="GET">
                            <strong>Are you sure you want to cancel this appointment?</strong>
                            <input type="hidden" value="" name="apptId" id="cancelId">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('.cancelBtn').click(function() {
                var apptID = $(this).val();
                $('#cancelId').val(apptID);
            })
        })
    </script>
@endsection
