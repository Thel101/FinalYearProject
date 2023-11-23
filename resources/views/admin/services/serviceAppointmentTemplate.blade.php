@extends('master')
@section('title', $clinic->clinic_name)
@section('content')
@section('pageTitle', 'Service Appointments')


@if (session('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('message') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div class="col-12">

    <ul class="nav nav-tabs row">
        <li class="nav-item col-md-3">
            <a class="nav-link {{ request()->routeIs('admin.bookedServices') ? 'active' : 'bg-primary' }}"
                href="{{ route('admin.bookedServices') }}">New <span
                    class="ml-2 badge badge-info text-dark">{{ $counts[0] }}</span></a>
        </li>
        <li class="nav-item col-md-3">
            <a class="nav-link {{ request()->routeIs('admin.recordedServices') ? 'active' : 'bg-success' }}"
                href="{{ route('admin.recordedServices') }}">Recorded <span
                    class="ml-2 badge badge-info text-dark">{{ $counts[1] }}</span></a>
        </li>
        <li class="nav-item col-md-3">
            <a class="nav-link  {{ request()->routeIs('admin.cancelledServices') ? 'active' : 'bg-danger' }}"
                href="{{ route('admin.cancelledServices') }}">Cancelled<span
                    class="ml-2 badge badge-info text-dark">{{ $counts[2] }}</span></a>
        </li>
        <li class="nav-item col-md-3">
            <a class="nav-link {{ request()->routeIs('admin.missedServices') ? 'active' : 'bg-warning' }}"
                href="{{ route('admin.missedServices') }}">Missed
                <span
                class="ml-2 badge badge-info text-dark">{{ $counts[3] }}</span></a>
        </li>
    </ul>
    <div class="card-body">
        @yield('booked')
        @yield('recorded')
        @yield('cancelled')
        @yield('missed')
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

@endsection
