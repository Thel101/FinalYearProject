@extends('patient.Account.profile')
@section('content')
@section('pageTitle', 'Clinic Available Services')

@if (session('cancelMessage'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('cancelMessage') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card">
    <div class="card-header">
        <h3 class="card-title">My Service Appointments</h3>
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
                        <th>Clinics Details</th>
                        <th>Patient Details</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($appointments as $a)
                        <tr>

                            <td>{{ $a->id }}</td>
                            <td>
                                <div class="lh-lg">{{ $a->service_name }}</div>
                                <div class="lh-lg">{{ $a->appointment_date }}</div>
                                <div class="lh-lg">{{ $a->time_slot }}</div>
                            </td>

                            <td>
                                <div class="lh-lg">{{ $a->patient_name }}</div>
                                <div class="lh-lg">{{ $a->patient_age }}</div>
                                <div class="lh-lg">{{ $a->phone_1 }}</div>
                                <div class="lh-lg">{{ $a->phone_2 }}</div>
                            </td>
                            <td>
                                @if ($a->status == 'booked')
                                    <span class="badge rounded-pill bg-info text-dark">{{ $a->status }}</span>
                                @elseif ($a->status == 'cancelled')
                                    <span class="badge rounded-pill bg-danger text-dark">{{ $a->status }}</span>
                                @elseif ($a->status == 'missed')
                                    <span class="badge rounded-pill bg-warning text-dark">{{ $a->status }}</span>
                                @else
                                    <span class="badge rounded-pill bg-success text-dark">{{ $a->status }}</span>
                                @endif
                            </td>

                            <td>
                                <a class="btn btn-sm btn-success updBtn"
                                    href="{{ route('doctor.appointmentConfirm', $a->id) }}" title="download booking"><i
                                        class="fa-solid fa-file-arrow-down"></i></a>
                                @if ($a->status != 'cancelled' && $a->status != 'missed')
                                    @if ($a->isWithinRange == true)
                                        <button type="button" class="btn btn-sm btn-danger cancelBtn"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal" data-status="inactive"
                                            value="{{ $a->id }}" title="cancel appointments"><i
                                                class="fa-solid fa-ban"></i></button>
                                    @endif

                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @endif
    <!-- cancel appointment modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Appointment Cancellation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('serviceAppointment.cancel') }}" method="GET">

                            <strong>Are you sure you want to cancel this appointment?</strong>

                            <input type="hidden" value="" name="appointmentID" id="apptID">
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



    <!-- /.card-body -->
</div>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {
        $('#doctorAppointmentTable').dataTable({
            "autoWidth": false,
            "columns": [{
                    "width": "10%"
                },
                null,
                null, // automatically calculates
                null,
                {
                    "width": "5%"
                } // remaining width
            ]
        });
        $('.cancelBtn').click(function() {
            var appointmentId = $(this).val();
            $('#apptID').val(appointmentId);

        })
    })
</script>
@endsection
