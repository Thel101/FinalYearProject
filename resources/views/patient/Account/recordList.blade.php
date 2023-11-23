@extends('patient.Account.profile')
@section('content')
@section('pageTitle', 'Clinic Available Services')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">My Medical Records</h3>
    </div>
    <div class="card-body">

        <div class="bg-success" id="selfRecordHeader">
            <p class="p-2 lead">Self Medical Records</p>

        </div>
        <div class="card-body" id="selfRecord">
            <form>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="day">Drug</label>
                            <input type="text" name="day[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="day">Dose</label>
                            <input type="text" name="day[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="day">Frequency</label>
                            <input type="text" name="day[]" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="bg-primary" id="consultationRecordHeader">
            <p class="p-2 lead">Consultation Records</p>

        </div>
        <div class="card-body" id="consultationRecords">

            <ul class="list-group">
                @foreach ($consultationRecordLists as $cRecord)
                    <li class="list-group-item">
                        <div>
                            <p> <span class="text-bold">Attending doctor:</span> {{ $cRecord->doctor_name }}</p>
                            <p> <span class="text-bold">Appointment date:</span> {{ $cRecord->appointment_date }}</p>
                            <p class="text-bold">Result File
                                <a class="btn btn-primary"
                                    href="{{ route('patient.consultRecordDetail', $cRecord->appointment_id) }}">View
                                    Records</a>
                            </p>
                        </div>
                    </li>
                @endforeach

            </ul>


        </div>

        <div class="bg-secondary" id="labReportsHeader">
            <p class="p-2 lead">Lab reports</p>
        </div>
        <div id="labReports">
            <div>
                <ul class="list-group">
                    @foreach ($serviceRecordLists as $sRecord)
                        <li class="list-group-item">
                            <div>
                                <p> <span class="text-bold">Booked service:</span> {{ $sRecord->service_name }}</p>
                                <p> <span class="text-bold">Appointment date:</span> {{ $sRecord->appointment_date }}
                                </p>
                                <p class="text-bold">Result File
                                    <a class="btn btn-primary"
                                        href="{{ url(Storage::url($sRecord->result_file)) }}">Open</a>
                                    <a class="btn btn-success"
                                        href="{{ url(Storage::url($sRecord->result_file)) }}">Download</a>
                                </p>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>

        </div>
    </div>

</div>


@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {
        $('#selfRecord').hide();
        $('#selfRecordHeader').click(function() {
            $('#selfRecord').toggle();
        })

        $('#consultationRecords').hide();
        $('#consultationRecordHeader').click(function() {
            $('#consultationRecords').toggle();
        })
        $('#labReports').hide();
        $('#labReportsHeader').click(function() {
            $('#labReports').toggle();
        })
    })
</script>
@endsection
