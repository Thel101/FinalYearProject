@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Add doctor')

<div class="alert alert-warning alert-dismissible fade show" id="existDoctor" role="alert">
    <strong>Doctor Already Exists</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>


<div class="col-md-10 offset-1">
    <!-- general form elements -->
    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title">Do you want to add this doctor to the clinic?</h3>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-3">
                    <img style="width: 200px; height: 200px" class="img img-thumbnail"
                        src="{{ asset('storage/' . $existing_doctor->photo) }}">
                </div>
                <div class="col-9">
                    <div class="row my-1">
                        <h5 class="col-3">Name:</h5>
                        <h5 class="col-7 lead"> {{ $existing_doctor->name }}</h5>
                    </div>
                    <div class="row my-1">
                        <h5 class="col-3">Email:</h5>
                        <h5 class="col-7 lead"> {{ $existing_doctor->email }}</h5>
                    </div>
                    <div class="row my-1">
                        <h5 class="col-3">Phone:</h5>
                        <h5 class="col-7 lead"> {{ $existing_doctor->phone }}</h5>
                    </div>
                    <div class="row my-1">
                        <h5 class="col-3">SAMA No:</h5>
                        <h5 class="col-7 lead"> {{ $existing_doctor->license_no }}</h5>
                    </div>
                    <div class="row my-1">
                        <h5 class="col-3">Degreee:</h5>
                        <h5 class="col-7 lead"> {{ $existing_doctor->degree }}</h5>
                    </div>
                    <div class="row my-1">
                        <h5 class="col-3">Specialty:</h5>
                        <h5 class="col-7 lead"> {{ $existing_doctor->specialty_id }}</h5>
                    </div>
                    <div class="row my-1">
                        <h5 class="col-3">Fees:</h5>
                        <h5 class="col-7 lead"> {{ $existing_doctor->consultation_fees }} MMK</h5>
                    </div>

                </div>
                <form action="{{ route('admin.addDoctor') }}" method="POST">
                    @csrf
                    <input type="hidden" name="doctorId" value="{{ $existing_doctor->id }}">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title" id="scheduleForm">Doctor Shceudle</h3>
                        </div>
                        <div class="card-body" id="add-schedule">
                            <div id="schedules">
                                <div class="row schedule-row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="day">Schedule Day</label>
                                            <input type="text" name="day[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="day">Start Time</label>
                                            <input type="time" name="startTime[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="day">End Time</label>
                                            <input type="time" name="endTime[]" class="form-control">
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <input type="button" class="btn btn-primary" value="Add Schedules" id="add-row">
                        </div>
                    </div>
                    <button class="btn btn-primary my-3" type="submit">Add Doctor to Clinic</button>
                </form>
            </div>


        </div>

    </div>
    <!-- /.card -->
</div>

@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {
        $('#add-schedule').hide();
        $('#scheduleForm').click(function() {
            $('#add-schedule').toggle();
        });
        const data = $('#schedules');
        $('#add-row').click(function() {
            const newRow = $('<div>').html(`
            <div class="row">
                <div class="col-4">
                            <div class="form-group">

                                <input type="text" name="day[]" class="form-control" placeholder="day">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">

                                <input type="time" name="startTime[]" class="form-control" placeholder="start time">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">

                                <input type="time" name="endTime[]" class="form-control" placeholder="end time">
                            </div>
                        </div>
                    </div>
        `);
            $(data).append(newRow);

        });
    })
</script>
@endsection
