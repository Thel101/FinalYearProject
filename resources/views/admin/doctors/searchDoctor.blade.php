@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Search Doctor')

@if (session('message'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('message') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="col-md-10 offset-1">

    <form method="POST" action="{{ route('admin.searchDoctor') }}">
        @csrf
        <div class="d-flex justify-content-center">
            <div class="mb-3 col-6">
                <label for="docName" class="form-label">Doctor Name</label>
                <input type="text" class="form-control" name="doctorName" id="docName"
                    placeholder="Enter doctor name" required>
            </div>

        </div>

        <div class="d-flex justify-content-center">
            <div class="col-6">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-block" type="submit">Search</button>
                </div>
            </div>

        </div>


    </form>
</div>
<div>
    <div class="my-2 offset-2">
        <a href="{{route('admin.doctorList')}}">Back to List</a>
    </div>
    @if (!is_null($doctors) && count($doctors) > 0)

        <div class="d-flex justify-content-center">
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="text-center mt-3">Search Results</h4>
                </div>
                <div class="card-body">
                    <table id="doctorTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Specialty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctors as $d)
                                <tr>
                                    <td><img style="width: 100px; height: 100px" class="img img-thumbnail"
                                            src="{{ asset('storage/' . $d->photo) }}"></td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->email }}</td>
                                    <td>{{ $d->specialty_name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btnAdd" data-bs-toggle="modal"
                                            data-bs-target="#confirmForm" value="{{ $d->id }}"><i
                                                class="fa-solid fa-plus mr-2"></i>Add</button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="confirmForm" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Doctor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('admin.doctorRemove') }}" method="GET">
                                    <strong>Are you sure you want to add doctor to the clinic?</strong>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary btnConfirm" value=""
                                            data-bs-toggle="modal" data-bs-target="#scheduleForm">Confirm</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="scheduleForm" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Doctor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('admin.addDoctor') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="doctorID" id="doctorID" value="">
                                    <div id="schedules">
                                        <p class="text-danger lead" id="warningMessage"></p>
                                        <div class="row schedule-row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="day">Schedule Day</label>
                                                    <input type="text" name="day[]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="day">Start Time</label>
                                                    <input type="time" name="startTime[]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="day">End Time</label>
                                                    <input type="time" name="endTime[]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-2" style="margin-top: 3ch">
                                                <input type="button" class="btn btn-primary" value="Add"
                                                    id="add-row">
                                            </div>


                                        </div>


                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add
                                            Doctor</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    @else
    @endif
</div>

@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {
        $('.btnAdd').click(function() {
            var docId = $(this).val();
            $('.btnConfirm').val(docId);
            console.log($('.btnConfirm').val());

        });
        $('.btnConfirm').click(function() {
            $('#confirmForm').hide();
            var Doc_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "http://127.0.0.1:8000/admin/doctor/search/results/" + Doc_id,
                success: function(response) {
                    var message = response.message;
                    $('#warningMessage').text(message);
                }
            });
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
                        <div class="col-3">
                            <div class="form-group">

                                <input type="time" name="startTime[]" class="form-control" placeholder="start time">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">

                                <input type="time" name="endTime[]" class="form-control" placeholder="end time">
                            </div>
                        </div>
                    </div>
        `);
            $(data).append(newRow);

        });

    });
</script>
@endsection
