@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Register Medical Services')

@if (session('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="col-md-10 offset-1">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Services Information</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="{{ route('admin.serviceRegister') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body row">
                <div class="col-6">

                    <div class="form-group">
                        <label for="name">Service name</label>
                        <input type="text" name="name" class="form-control" id="serviceName"
                            placeholder="Enter service name">
                    </div>
                    <div class="form-group">
                        <label for="photo">Services Photo</label>
                        <input type="file" name="photo" class="form-control" id="servicePhoto">
                    </div>


                    <div class="form-group">
                        <label for="category">Service Category</label>
                        <select class="form-select" aria-label="Default select example" name="category">
                            <option selected>Choose service category</option>
                            @foreach ($category as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="serviceDescription" class="form-control"></textarea>

                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input class="form-control" type="number" name="price" id="servicePrice">
                    </div>

                </div>

                <div class="col-6">

                    <div class="form-group" id="components">
                        <label for="components">Components included in service<i id="plusComponents"
                                class="fa-solid fa-plus ml-2"></i></label>
                        <input type="tel" name="components[]" class="form-control mb-1" id="serviceComponents">
                    </div>


                    <div class="form-group">
                        <label for="rate">Promotion Rate</label>
                        <input type="number" name="rate" class="form-control" id="promoRate"
                            placeholder="Enter rate for promotion . e.g. 10">
                    </div>

                    <div class="form-group">
                        <label for="promotion">Promotion</label>
                        <input type="number" name="promotion" class="form-control" id="servicePromotion"
                            placeholder="Enter promotion price">
                    </div>


                </div>



            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary offset-4 col-4">Add Service</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>

@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {
        var addNewComponent = `<input type="tel" name="components[]" class="form-control mb-1" id="docPhone"
                            >`
        $('#plusComponents').click(function() {
            $('#components').append(addNewComponent);
        });
    })
</script>
@endsection
