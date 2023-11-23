@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Clinic Available Doctor')
<div class="card-body">
    <table id="doctorScheduleTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Doc ID</th>
                <th>Name</th>
                <th>Specialty</th>
                <th>Schedule Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($doctorSchedulesWithScheduleDays as $schedule )
            <tr>

                <td>{{$schedule['doctor_id']}}</td>
                <td>{{$schedule['doctor_name']}}</td>
                <td>{{$schedule['doctor_specialty']}}</td>
                <td>{{$schedule['schedule_day']}}</td>
                <td>{{$schedule['start_time']}}</td>
                <td>{{$schedule['end_time']}}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary updBtn" data-bs-toggle="modal"
                    data-bs-target="#updateForm" title="update" data-doctor-id="{{$schedule['doctor_id']}}" data-clinic-id="{{$schedule['clinic_id']}}" data-doctor_name="{{$schedule['doctor_name']}}"
                    data-day="{{$schedule['schedule_day']}}"
                    data-start="{{$schedule['start_time']}}"
                    data-end="{{$schedule['end_time']}}" ><i
                    class="fa-solid fa-pen-to-square"></i></button>
                </td>
            </tr>

            @endforeach
        </tbody>

    </table>
</div>

<div class="modal fade" id="updateForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Doctor Schedules</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form class="row g-3" method="POST" act>
                        @csrf
                        <input type="hidden" name="docID" id="id" value="">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="docName">Doctor name</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="docLicense">Schedule Day</label>
                                <input type="text" name="day" class="form-control" id="scheduleDay">
                            </div>
                            <div class="form-group">
                                <label for="docLicense">Start Time</label>
                                <input type="time" name="start" class="form-control" id="startTime">
                            </div>
                            <div class="form-group">
                                <label for="docLicense">End Time</label>
                                <input type="time" name="end" class="form-control" id="endTime">
                            </div>


                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="docPhone">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" id="docPhone"
                                    placeholder="Enter doctor phone number">
                            </div>
                            <div class="form-group">
                                <label for="docEmail">Email address</label>
                                <input type="email" name="email" class="form-control" id="docEmail"
                                    placeholder="Enter email address">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="docEmail">Consultation Duration</label>
                                <input type="text" name="duration" class="form-control" id="docDuration">
                            </div>
                            <div class="form-group">
                                <label for="docFees">Consultation Fees</label>
                                <input type="text" name="fees" class="form-control" id="docFees">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="docDegree">Doctor Degree</label>
                                    <input type="text" name="degree" class="form-control" id="docDegree">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Specialty</label>
                                    <select class="form-select" name="specialty" id="docSpecialty">

                                        </select>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="docName">Doctor Photo</label>
                                    <input type="file" name="photo" class="form-control" id="photo">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">

                            <div class="form-group">
                                <label for="docExperience">Experience</label>
                                <input type="text" name="experience" class="form-control" id="docExperience">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
    $(document).ready(function(){
        $('#doctorScheduleTable').DataTable();
    });
</script>

@endsection
