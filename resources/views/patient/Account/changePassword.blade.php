@extends('patient.profile')
@section('content')
@section('pageTitle', 'Password Change Page')

@if (session('successMessage'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('successMessage') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('errorMessage'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('errorMessage') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container mt-3 p-3 col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header text-center">
            <h4>Password Change</h4>
        </div>
        <form action="{{route('patient.passwordChange')}}" method="POST">

            @csrf
            <div class="card-body">

                <div class="mb-3">
                    <label for="current" class="form-label">Current Password</label>
                    <div class="input-group">
                        <input type="password" name="currentPassword" class="form-control @error('currentPassword')
                            is-invalid
                        @enderror" id="current"><span
                            class="input-group-text">
                            <i id="showCurrent" class="fa-regular fa-eye-slash"></i>
                        </span>
                        <div class="invalid-feedback">
                            @error('currentPassword')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="mb-3">
                    <label for="new" class="form-label">New Password</label>
                    <div class="input-group">
                        <input type="password" name="newPassword" class="form-control @error('newPassword')
                        is-invalidX
                        @enderror" id="new">
                        <span class="input-group-text">
                            <i id="showNew" class="fa-regular fa-eye-slash"></i>
                        </span>
                        <div class="invalid-feedback">
                            @error('newPassword')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="mb-3">
                    <label for="confirm" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="confirmPassword" class="form-control @error('confirmPassword')
                            is-invalid
                        @enderror" id="confirm">
                        <span class="input-group-text">
                            <i id="showConfirm" class="fa-regular fa-eye-slash"></i>
                        </span>
                        <div class="invalid-feedback">
                            @error('confirmPassword')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>


        </form>
    </div>
</div>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {
        $(document).ready(function() {
            $('#showCurrent').click(function() {
                var password = $('#current');
                var type = password.attr('type');
                if (type === "password") {
                    password.attr("type", "text");
                    $("#showCurrent i").removeClass("fa-regular fa-eye-slash").addClass(
                        "fa-regular fa-eye");
                } else {
                    password.attr("type", "password");
                    $("#showCurrent i").removeClass("fa-regular fa-eye").addClass(
                        "fa-regular fa-eye-slash");
                }
            });

            $('#showNew').click(function() {
                var password = $('#new');
                var type = password.attr('type');
                if (type === "password") {
                    password.attr("type", "text");
                    $("#showNew i").removeClass("fa-regular fa-eye-slash").addClass(
                        "fa-regular fa-eye");
                } else {
                    password.attr("type", "password");
                    $("#showNew i").removeClass("fa-regular fa-eye").addClass(
                        "fa-regular fa-eye-slash");
                }
            });

            $('#showConfirm').click(function() {
                var password = $('#confirm');
                var type = password.attr('type');
                if (type === "password") {
                    password.attr("type", "text");
                    $("#showConfirm i").removeClass("fa-regular fa-eye-slash").addClass(
                        "fa-regular fa-eye");
                } else {
                    password.attr("type", "password");
                    $("#showConfirm i").removeClass("fa-regular fa-eye").addClass(
                        "fa-regular fa-eye-slash");
                }
            });
        });

    })
</script>
@endsection
