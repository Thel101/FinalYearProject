@extends('master')
@section('title', 'Specialty List')
@section('content')
@section('pageTitle', 'Doctory Specialty List')

@if (session('message'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('message') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('EditSuccess'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('EditSuccess') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('DeactivateSuccess'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('DeactivateSuccess') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div class="col-12">
    <div>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#registerModal"><i
                class="fa-solid fa-plus mr-1"></i>Add new doctor
            specialty</button>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registered Doctor Specialty</h3>
        </div>
        <!-- /.card-header -->


        @if (count($specialties) == 0)
            <div class="card-body">
                <div>
                    <h5 class="text-danger text-center">There is no registered doctor specialty yet!</h5>
                </div>
            </div>
        @else
            <div class="card-body">
                <table id="clinicTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specialties as $s)
                            <tr>
                                <td>{{ $s->id }}</td>
                                <td id="clinicName">{{ $s->name }}</td>

                                <td>
                                    <button type="button" class="btn btn-primary updateBtn" data-bs-toggle="modal"
                                        data-bs-target="#updateForm" value="{{ $s->id }}" title="update"><i
                                            class="fa-solid fa-pen-to-square"></i></button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @endif
        </tbody>

        </table>


        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- /.card -->
    <!-- update modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Doctor Specialty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" action="{{ route('specialty.register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="specialtyName">Specialty name</label>
                                <input type="text" name="specialtyName" class="form-control" id="name"
                                    value="">
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Specialty</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- deactivate modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Clinic Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('clinic.deactivate') }}" method="GET">
                            <strong>Are you sure you want to deactivate this clinic?</strong>
                            <input type="hidden" value="" name="clinicId" id="updateId">
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
            $('#clinicTable').DataTable();

            // function changeTimeFormat(str) {

            //     let sep = ":"
            //     let ampm = " am"
            //     var res = str.split(":", 2);

            //     let hours = res[0];
            //     let mins = res[1];
            //     res[2] = mins;
            //     res[1] = sep;
            //     res[3] = ampm;
            //     if (hours >= 12) {
            //         res[3] = " pm";
            //     }
            //     if (hours > 12) {
            //         res[0] = hours - 12;
            //     }
            //     return time = res.join("");
            // }

            // $('tbody tr').each(function(index, row) {
            //     $opening = $(this).find('.opening').text();
            //     $closing = $(this).find('.closing').text();
            //     let opening = changeTimeFormat($opening);
            //     let closing = changeTimeFormat($closing);

            //     $(this).find('.opening').text(opening);
            //     $(this).find('.closing').text(closing);

            // })
            // $('.updateBtn').click(function() {
            //     var id = $(this).val();
            //     $.ajax({
            //         type: "GET",
            //         url: "http://127.0.0.1:8000/superadmin/clinics/edit/" + id,
            //         success: function(response) {
            //             $('#id').val(response.clinic_data.id);
            //             $('#name').val(response.clinic_data.name);
            //             $('#township').val(response.clinic_data.township);
            //             $('#address').val(response.clinic_data.address);
            //             $('#phone').val(response.clinic_data.phone);
            //             $('#opening').val(response.clinic_data.opening_hour);
            //             $('#closing').val(response.clinic_data.closing_hour);

            //         }
            //     });
            // })

            // $('.deactivateBtn').click(function() {
            //     var id = $(this).val();
            //     $('#updateId').val(id);
            // })

        });
    </script>
@endsection
