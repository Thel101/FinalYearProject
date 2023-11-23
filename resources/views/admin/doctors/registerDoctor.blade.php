@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Register Doctor')

@if (session('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="col-md-10 offset-1">
    <form action="{{ route('admin.doctorRegister') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <!-- general form elements -->
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Doctor Log-in Information</h3> </i>
        </div>
        <!-- /.card-header -->

        <!-- form start -->

            <div class="card-body row">
                <div class="col-6">

                    <div class="form-group">
                        <label for="docName">Doctor name</label>
                        <input type="text" name="name" class="form-control" id="name"
                            placeholder="Enter doctor name"
                            @if (session('message')) value="{{ $existing_doctor->name }}" @endif value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="docName">Doctor Photo</label>
                        <input type="file" name="photo" class="form-control" id="photo">
                    </div>


                    <div class="form-group">
                        <label for="docLicense">License Number</label>
                        <input type="text" name="license" class="form-control" id="docLicense" placeholder="172789" value="{{old('license')}}">
                    </div>

                    <div class="form-group">
                        <label for="docEmail">Email address</label>
                        <input type="email" name="email" class="form-control" id="docEmail"
                            placeholder="Enter email address" value="{{old('email')}}">
                    </div>

                </div>

                <div class="col-6">

                    <div class="form-group">
                        <label for="docPhone">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" id="docPhone"
                            placeholder="Enter doctor phone number" value="{{old('phone')}}">
                    </div>

                    <div class="form-group">
                        <label>Specialty</label>
                        <select class="form-select" aria-label="Default select example" name="specialty">
                            <option selected>Choose doctor specialty</option>
                            @foreach ($specialties as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="docDegree">Doctor Degree</label>
                        <input type="text" name="degree" class="form-control" id="docDegree"
                            placeholder="e.g. MBBS, Yangon" value="{{old('degree')}}">
                    </div>

                    <div class="form-group">
                        <label for="docExperience">Experience</label>
                        <input type="text" name="experience" class="form-control" id="docExperience"
                            placeholder="Enter doctor clinical experience" value="{{old('experience')}}">
                    </div>

                    <div class="form-group">
                        <label for="docFees">Consultation Fees</label>
                        <input type="number" name="fees" class="form-control" id="docFees"
                            placeholder="Enter consultation fees" value="{{old('fees')}}">
                    </div>

                    <div class="form-group">
                        <label for="duration">Consultation Duration</label>
                        <input type="text" pattern="\d{}2:\d{2}:\d{2}" name="duration" class="form-control" id="duration"
                            placeholder="00:00:00" value="{{old('duration')}}">
                    </div>
                </div>



            </div>

            <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title" id="scheduleForm">Doctor Shceudle Form</h3>
        </div>
        <div class="card-body" id="add-schedule">
            <div id="schedules">
                <div class="row schedule-row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="day">Schedule Day</label>
                            <input type="text" name="day[]" class="form-control" value="{{old('day[]')}}">
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
    <div class="row">
        <div class="col-8 offset-2">
            <button type="submit" class="btn btn-block btn-primary my-3">Add Doctor</button>
        </div>
    </div>

</form>
</div>

@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {

        $('#PhoneNumber2').hide();
        $section = $('#PhoneNumber2');
        $('#addNewPhone').click(function() {
            $('#PhoneNumber2').toggle();


        });
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
