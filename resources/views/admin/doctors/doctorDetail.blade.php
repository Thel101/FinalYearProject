@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Add doctor')

<div class="my-2">
    <a href="{{route('admin.doctorList')}}" class="offset-1"> Back to doctor list</a>
</div>

<div class="col-md-10 offset-1">
    <form action="{{ route('adminDoctor.edit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- general form elements -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Doctor Log-in Information</h3> </i>
            </div>
            <!-- /.card-header -->

            <!-- form start -->

            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ asset('storage/' . $doctor->photo) }}" class="img img-thumbnail">

                    </div>
                    <input type="hidden" name="docID" value="{{ $doctor->id }}">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="docName">Doctor name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Enter doctor name" value="{{ $doctor->name }}">
                        </div>

                        <div class="form-group">
                            <label for="docLicense">License Number</label>
                            <input type="text" name="license" class="form-control" id="docLicense"
                                value="{{ $doctor->license_no }}">
                        </div>

                        <div class="form-group">
                            <label for="docEmail">Email address</label>
                            <input type="email" name="email" class="form-control" id="docEmail"
                                value="{{ $doctor->email }}">
                        </div>
                        <div class="form-group">
                            <label for="docPhone">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" id="docPhone"
                                value="{{ $doctor->phone }}">
                        </div>


                    </div>
                </div>
                <div class="container">
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label>Specialty</label>
                                <select class="form-select" aria-label="Default select example" name="specialty">
                                    <option value="{{ $doctorSpecialty->specialty_id }}" selected>
                                        {{ $doctorSpecialty->specialty_name }}</option>

                                    @foreach ($specialties as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="docDegree">Doctor Degree</label>
                                <input type="text" name="degree" class="form-control" id="docDegree"
                                    value="{{ $doctor->degree }}">
                            </div>


                            <div class="form-group">
                                <label for="docExperience">Experience</label>
                                <input type="text" name="experience" class="form-control" id="docExperience"
                                    value="{{ $doctor->experience }}">
                            </div>
                        </div>
                        <div class="col-6">

                            <div class="form-group">
                                <label for="docDegree">Doctor Photo</label>
                                <input type="file" name="photo" class="form-control" id="docPhoto">
                            </div>
                            <div class="form-group">
                                <label for="docFees">Consultation Fees</label>
                                <input type="number" name="fees" class="form-control" id="docFees"
                                    value="{{ $doctor->consultation_fees }}">
                            </div>

                            <div class="form-group">
                                <label for="docEmail">Consultation Duration</label>
                                <input type="text" name="duration" class="form-control"
                                    value="{{ $doctor->consultation_duration }}" id="docDuration">
                            </div>

                        </div>


                    </div>
                </div>


            </div>



            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card card-secondary">
            <div class="card-header">
                <div class="row">
                    <div class="col-auto me-auto">
                        <h3 class="card-title mt-1" style="margin-top: 1ch" id="scheduleForm">This is Shceudle Form</h3>
                    </div>
                    <div class="col-auto">
                        <button type="button" style="margin-top: 1ch" class="card-title btn btn-sm btn-primary" value="Add Schedules"
                            id="add-row"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            </div>
            @php
                $rowCounter = 1;
            @endphp
            <div class="card-body" id="add-schedule">
                <div id="schedules">
                    <div class="row schedule-row">
                        @foreach ($doctor->clinics as $clinic)
                            <div class="row" id="row_{{ $rowCounter }}">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="day">Schedule Day</label>
                                        <input type="text" name="day[]" class="form-control"
                                            value="{{ $clinic->pivot->schedule_day }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="day">Start Time</label>
                                        <input type="time" name="startTime[]" class="form-control"
                                            value="{{ $clinic->pivot->start_time }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="day">End Time</label>
                                        <input type="time" name="endTime[]" class="form-control"
                                            value="{{ $clinic->pivot->end_time }}">
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="form-group" style="margin-top:3ch">
                                        <label></label>
                                        <button type="button" class="btn btn-danger btnRemove"
                                            data-target="row_{{ $rowCounter }}"><i
                                                class="fa-solid fa-circle-xmark"></i></button>
                                    </div>
                                </div>


                            </div>
                            @php
                                $rowCounter++;
                            @endphp
                        @endforeach


                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary my-3">Update Doctor</button>
                </div>

            </div>
        </div>

    </form>
</div>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {
        const scheduleRow = $('#schedules');
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
            $(scheduleRow).append(newRow);

        });
        $('.btnRemove').click(function() {
            var targetClass = ($(this).attr("data-target"));
            $("#" + targetClass).remove();

        });
    });
</script>
@endsection
