@extends('master')
@section('title', 'Admin List')
@section('content')
@section('pageTitle', 'Clinic Admin List')

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
    <div><a href="{{ route('admin.registerForm') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i>Add
            new
            clinics admin</a></div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registered Clinics Admin</h3>
        </div>
        <!-- /.card-header -->


        @if (count($admins) != 0)
            <div class="card-body">
                <table id="adminTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Clinic</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $a)
                            <tr>
                                <td>{{ $a->id }}</td>
                                <td id="clinicName">{{ $a->name }}</td>
                                <td id="clinicTownship">{{ $a->email }}</td>
                                <td id="clinicPhone">{{ $a->phone1 }} | {{ $a->phone2 }}</td>

                                @if ($a->status == 1)
                                    <td id="clinicStats"> Active </td>
                                @else
                                    <td id="clinicStats">Inactive</td>
                                @endif
                                <td class="opening">{{ $a->clinic_name }}</td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-primary updBtn" data-bs-toggle="modal"
                                        data-bs-target="#updateForm" value="{{ $a->id }}" title="update"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                    @if ($a->status == 1)
                                        <button type="button" class="btn btn-sm btn-danger deactivateBtn"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal"
                                            value="{{ $a->id }}" title="deactivate"><i
                                                class="fa-solid fa-circle-xmark deactivateBtn"></i></button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-info deactivateBtn"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal"
                                            value="{{ $a->id }}" title="reactivate"><i
                                                class="fa-solid fa-rotate-left"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @else
            <div class="card-body">
                <div>
                    <h5 class="text-danger text-center">There is no registered clinics admin yet!</h5>
                </div>
            </div>

        @endif
        </tbody>

        </table>


        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- /.card -->
    <!-- update modal -->
    <div class="modal fade" id="updateForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Admin Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="row g-3" method="POST" action="{{ route('admin.edit') }}">
                            @csrf
                            <input type="hidden" name="adminId" id="id" value="">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Admin name</label>
                                    <input type="text" name="adminName" class="form-control" id="admin_name"
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="township">Email Address</label>
                                <input type="text" name="adminEmail" class="form-control" id="admin_email"
                                    value="">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Phone 1</label>
                                    <input type="text" name="phone1" class="form-control" id="phone1"
                                        value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone 2</label>
                                    <input type="text" name="phone2" class="form-control" id="phone2"
                                        value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <select class="form-select" name="clinic" id="clinic">
                                            <option selected>Choose Clinic</option>
                                            @foreach ($clinics as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-select" name="role" id="role">
                                            <option selected>Choose Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="clinic admin">Clinic Admin</option>
                                            <option value="clinic staff">Clinic Staff</option>

                                        </select>
                                    </div>
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
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
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
            $('#adminTable').DataTable();

            $('.updBtn').click(function() {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "http://127.0.0.1:8000/superadmin/clinics/admins/edit/" + id,
                    success: function(response) {
                        $('#id').val(response.admin_data.id);
                        $('#admin_name').val(response.admin_data.name);
                        $('#admin_email').val(response.admin_data.email);
                        $('#phone1').val(response.admin_data.phone1);
                        $('#phone2').val(response.admin_data.phone2);


                    }

                });
            })

            // $('.deactivateBtn').click(function() {
            //     var id = $(this).val();
            //     $('#updateId').val(id);
            // })

        });
    </script>
@endsection
