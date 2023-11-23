@extends('doctor.doctorDashboard')
@section('content')
    <style>
        /* Style for active links */
        .nav-link.active {
            color: #e11d1d;
            background-color: #f4f4f4;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }
    </style>
    <ul class="nav nav-tabs row">
        <li class="nav-item col-md-3">
            <a class="nav-link {{ request()->routeIs('doctor.newAppointments') ? 'active' : 'bg-primary' }}"
                href="{{ route('doctor.newAppointments') }}">New <span
                    class="ml-2 badge badge-info text-dark">{{ $counts[0] }}</span></a>
        </li>
        <li class="nav-item col-md-3">
            <a class="nav-link {{ request()->routeIs('doctor.consultedAppointments') ? 'active' : 'bg-success' }}"
                href="{{ route('doctor.consultedAppointments') }}">Consulted <span
                    class="ml-2 badge badge-info text-dark">{{ $counts[1] }}</span></a>
        </li>
        <li class="nav-item col-md-3">
            <a class="nav-link {{ request()->routeIs('doctor.cancelledAppointments') ? 'active' : 'bg-danger' }}"
                href="{{ route('doctor.cancelledAppointments') }}">Cancelled <span
                    class="ml-2 badge badge-info text-dark">{{ $counts[2] }}</a>
        </li>
        <li class="nav-item col-md-3">
            <a class="nav-link {{ request()->routeIs('doctor.missedAppointments') ? 'active' : 'bg-warning' }}"
                href="{{ route('doctor.missedAppointments') }}">Missed
                <span class="ml-2 badge badge-info text-dark">{{ $counts[3] }}</a>
        </li>
    </ul>
    <div class="card-body">
        @yield('newAppointmentTable')
        @yield('consultedAppointmentTable')
        @yield('cancelledAppointmentTable')
        @yield('missedAppointmentTable')

    </div>
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('a')
        })
    </script>
@endsection
