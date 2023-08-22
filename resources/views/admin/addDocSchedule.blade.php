@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Add Doctor Schedule')

@if (session('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="col-md-6 offset-3">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Doctor Schedule</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="{{ route('admin.addSchedules') }}" method="POST">
            @csrf

            <div class="card-body">


                <div class="form-group">
                    <input type="hidden" name="doctorId" value="{{ $doctor->id }}">
                    <label for="doctorName">Doctor name</label>
                    <input type="text" name="name" class="form-control" id="docName"
                        value="{{ $doctor->name }}">
                </div>

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

            <div class="row">

                <div class="col-4 offset-4">
                    <input type="submit">
                </div>

            </div>
    </div>
    <!-- /.card-body -->


    </form>
</div>
<!-- /.card -->
</div>

@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {
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
