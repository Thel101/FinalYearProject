@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Clinic Available Doctor')

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


        @if (count($admins) == 0)
            <div class="card-body">
                <div>
                    <h5 class="text-danger text-center">There is no registered clinics admin yet!</h5>
                </div>
            </div>
        @else
            <div class="card-body">
                <table id="clinicTable" class="table table-bordered table-hover">
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
                                    <button type="button" class="btn btn-primary updateBtn" data-bs-toggle="modal"
                                        data-bs-target="#updateForm" value="{{ $a->id }}" title="update"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                    @if ($a->status == 1)
                                        <button type="button" class="btn btn-danger deactivateBtn"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal"
                                            value="{{ $a->id }}" title="deactivate"><i
                                                class="fa-solid fa-circle-xmark deactivateBtn"></i></button>
                                    @else
                                        <button type="button" class="btn btn-info deactivateBtn" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal" value="{{ $a->id }}"
                                            title="reactivate"><i class="fa-solid fa-rotate-left"></i></button>
                                    @endif
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
    <div class="modal fade" id="updateForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Clinic Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="row g-3" method="POST" action="{{ route('clinic.edit') }}">
                            @csrf
                            <input type="hidden" name="clinicId" id="id" value="">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Clinic name</label>
                                    <input type="text" name="clinicName" class="form-control" id="name"
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="township">Clinic township</label>
                                <input type="text" name="clinicTownship" class="form-control" id="township"
                                    value="">
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">Clinic address</label>
                                    <input type="text" name="clinicAddress" class="form-control" id="address"
                                        value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Clinic phone</label>
                                    <input type="text" name="clinicPhone" class="form-control" id="phone"
                                        value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="opening">Clinic opening hour</label>
                                        <input type="time" class="form-control" id="opening" name="openingHour"
                                            value="">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="closing">Clinic closing hour</label>
                                        <input type="time" class="form-control" id="closing" name="closingHour"
                                            value="">
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
