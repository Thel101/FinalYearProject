@extends('master')
@section('title', 'Clinic List')
@section('content')
@section('pageTitle', 'Clinic List')

@if (session('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
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
    <div><a href="{{ route('superAdmin.clinic') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i>Add new
            clinics</a></div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registered Clinics</h3>
        </div>
        <!-- /.card-header -->
        @if (count($clinics) == 0)
            <div class="card-body">
                <div>
                    <h5 class="text-danger text-center">There is no registered clinics yet!</h5>
                </div>
            </div>
        @else
            <div class="card-body">
                <table id="clinicTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Clinic</th>
                            <th>Township</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Opening Hour</th>
                            <th>Closing Hour</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clinics as $c)
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td id="clinicName">{{ $c->name }}</td>
                                <td id="clinicTownship">{{ $c->township }}</td>
                                <td id="clinicPhone">{{ $c->phone }}</td>

                                @if ($c->status == 1)
                                    <td id="clinicStats"> Active </td>
                                @else
                                    <td id="clinicStats">Inactive</td>
                                @endif
                                <td class="opening">{{ $c->opening_hour }}</td>
                                <td class="closing">{{ $c->closing_hour }} </td>

                                <td>
                                    <button type="button" class="btn btn-primary updateBtn" data-bs-toggle="modal"
                                        data-bs-target="#updateForm" value="{{ $c->id }}" title="update"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                    @if ($c->status == 1)
                                        <button type="button" class="btn btn-danger deactivateBtn"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal"
                                            value="{{ $c->id }}" title="deactivate"><i
                                                class="fa-solid fa-circle-xmark deactivateBtn"></i></button>
                                    @else
                                        <button type="button" class="btn btn-info deactivateBtn" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal" value="{{ $c->id }}"
                                            title="reactivate"><i class="fa-solid fa-rotate-left"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @endif
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
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('#clinicTable').DataTable();

            function changeTimeFormat(str) {

                let sep = ":"
                let ampm = " am"
                var res = str.split(":", 2);

                let hours = res[0];
                let mins = res[1];
                res[2] = mins;
                res[1] = sep;
                res[3] = ampm;
                if (hours >= 12) {
                    res[3] = " pm";
                }
                if (hours > 12) {
                    res[0] = hours - 12;
                }
                return time = res.join("");
            }

            $('tbody tr').each(function(index, row) {
                $opening = $(this).find('.opening').text();
                $closing = $(this).find('.closing').text();
                let opening = changeTimeFormat($opening);
                let closing = changeTimeFormat($closing);

                $(this).find('.opening').text(opening);
                $(this).find('.closing').text(closing);

            })
            $('.updateBtn').click(function() {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "http://127.0.0.1:8000/superadmin/clinics/edit/" + id,
                    success: function(response) {
                        $('#id').val(response.clinic_data.id);
                        $('#name').val(response.clinic_data.name);
                        $('#township').val(response.clinic_data.township);
                        $('#address').val(response.clinic_data.address);
                        $('#phone').val(response.clinic_data.phone);
                        $('#opening').val(response.clinic_data.opening_hour);
                        $('#closing').val(response.clinic_data.closing_hour);

                    }
                });
            })

            $('.deactivateBtn').click(function() {
                var id = $(this).val();
                $('#updateId').val(id);
            })

        });
    </script>
@endsection
