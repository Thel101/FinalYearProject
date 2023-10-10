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
    <div><a href="{{ route('admin.doctorForm') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i>Add
            new
            Doctor</a></div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registered Doctors</h3>
        </div>
        <!-- /.card-header -->


        @if (count($doctors) == 0)
            <div class="card-body">
                <div>
                    <h5 class="text-danger text-center">There is no registered doctors yet!</h5>
                </div>
            </div>
        @else
            <div class="card-body">
                <table id="doctorTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>SAMA</th>
                            <th>Degree</th>
                            <th>Specialty</th>
                            <th>Fees</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($doctors as $d)
                            <tr>

                                <td><img style="width: 100px; height: 100px" class="img img-thumbnail"
                                        src="{{ asset('storage/' . $d->photo) }}"></td>
                                <td>DR. {{ $d->name }}</td>

                                <td>{{ $d->email }}</td>
                                <td>{{ $d->phone }}</td>
                                <td>{{ $d->license_no }}</td>
                                <td>{{ $d->degree }}</td>
                                <td>{{ $d->specialty_name }}</td>
                                <td>{{ $d->consultation_fees }} MMK</td>
                                <td>
                                    <a class="btn btn-sm btn-primary updBtn" href="{{route('admin.doctorDetail', $d->id)}}" title="detail"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <button type="button" class="btn btn-sm btn-danger removeBtn" data-bs-toggle="modal"
                                    data-bs-target="#confirmForm" value="{{ $d->id }}" title="view doctor"><i class="fa-solid fa-user-xmark"></i></button>

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
    <!-- deactivate modal -->
    <div class="modal fade" id="confirmForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remove Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('admin.doctorRemove') }}" method="GET">
                            <strong>Are you sure you want to remove doctor from the clinic?</strong>
                            <input type="hidden" value="" name="doctorId" id="removeId">
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
            $('#doctorTable').DataTable();

            $('.updBtn').click(function(){
                var docId= $(this).val();
                $.ajax({
                    type: "GET",
                    url: "http://127.0.0.1:8000/admin/doctor/edit/" + docId,
                    success: function(response) {
                        $('#id').val(response.doctor_data.id);
                        $('#name').val(response.doctor_data.name);
                        $('#docLicense').val(response.doctor_data.license_no);
                        $('#docPhone').val(response.doctor_data.phone);
                        $('#docEmail').val(response.doctor_data.email);
                        $('#docDegree').val(response.doctor_data.degree);
                        $('#docDuration').val(response.doctor_data.consultation_duration)
                        $('#docFees').val(response.doctor_data.consultation_fees);
                        $('#docSpecialty').val(response.doctor_data.specialty_id);
                        $('#docExperience').val(response.doctor_data.experience);


                    }

                });
            });
            $('.removeBtn').click(function() {
                var id = $(this).val();
                $('#removeId').val(id);

            })
        })
    </script>
@endsection
