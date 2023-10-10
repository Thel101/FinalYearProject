@extends('master')
@section('title', 'Service Category List')
@section('content')
@section('pageTitle', 'Medical Service Category List')

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
                class="fa-solid fa-plus mr-1"></i>Add new medical service category</button>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registered Medical Service Category</h3>
        </div>
        <!-- /.card-header -->


        @if (count($services) == 0)
            <div class="card-body">
                <div>
                    <h5 class="text-danger text-center">There is no registered medical service category yet!</h5>
                </div>
            </div>
        @else
            <div class="card-body">
                <table id="clinicTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $s)
                            <tr>
                                <td>{{ $s->id }}</td>
                                <td><img style="width: 50px; height:50px" class="img img-thumbnail" src="{{asset('storage/'. $s->photo)}}"></td></td>
                                <td id="clinicName">{{ $s->name }}</td>
                                @if ($s->status == 1)
                                    <td id="clinicStats"> Active </td>
                                @else
                                    <td id="clinicStats">Inactive</td>
                                @endif
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
    <!-- register modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Medical Service Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" action="{{ route('serviceCategory.register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="serviceName">Service Category name</label>
                                <input type="text" name="serviceName" class="form-control" id="name"
                                    value="">
                            </div>

                            <div class="form-group">
                                <label for="image">Service Image</label>
                               <input class="form-control" type="file" name="serviceImage" id="image">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Service Category</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- update modal -->
    <div class="modal fade" id="updateForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Medical Service Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" action="{{ route('serviceCategory.edit') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="serviceId" id="editId" value="">
                            <div class="form-group">
                                <label for="serviceName">Service Category name</label>
                                <input type="text" name="serviceName" class="form-control" id="editName"
                                    value="">
                            </div>

                            <div class="form-group">
                                <label for="image">Service Image</label>
                               <input class="form-control" type="file" name="serviceImage" id="image">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Service Category</button>
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


            $('.updateBtn').click(function() {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "http://127.0.0.1:8000/superadmin/clinics/serviceCategory/edit/" + id,
                    success: function(response) {
                        $('#editId').val(response.category_data.id);
                        $('#editName').val(response.category_data.name);


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
