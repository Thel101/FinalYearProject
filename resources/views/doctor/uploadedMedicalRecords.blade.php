@extends('doctor.doctorDashboard')
@section('content')
    <style>
        hr {
            height: 4px;
            border: none;
        }

        #hr1 {
            border-top: 3px dashed #ff0000;
            background-color: #ff0000;
        }

        #hr2 {
            border-top: 3px dashed #60f410;
            background-color: #60f410;
        }
    </style>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="mt-3">Upload medical records</h4>
        </div>
        <div class="card-body">
            <div>
                <form>
                    @csrf

                    <div class="form-group">
                        <label for="prescription">Record date: </label>
                        <span>{{ $doctorMedicalRecords->created_at }}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Patient Information</label>
                        <span class="d-block">{{ $doctorMedicalRecords->patient_name }}</span>
                        <span class="d-block">{{ $doctorMedicalRecords->patient_age }} yrs old</span>
                    </div>
                    <hr id="hr1">
                    <div class="form-group">
                        <label for="age">Current symptoms</label>
                        <span class="d-block">{{ $doctorMedicalRecords->current_symptoms }}</span>
                    </div>
                    <hr id="hr2">
                    <div class="form-group col-auto">
                        <label for="phone">General Medical History: </label>
                        @php
                            $medicalHistory = json_decode($doctorMedicalRecords->medical_history, true);
                        @endphp

                        @foreach ($medicalHistory as $m)
                            <span>{{ $m }}</span>,
                        @endforeach

                    </div>

                    <div class="form-group col-auto">
                        <label for="phone">Family History: </label>
                        <span>{{ $doctorMedicalRecords->family_history }}</span>
                    </div>

                    <div class="form-group col-auto">
                        <label for="phone">Surgical History: </label>
                        <span>{{ $doctorMedicalRecords->surgery_history }}</span>
                    </div>
                    <hr id="hr3">
                    <div class="form-group col-auto">
                        <label for="prescription">Prescription: </label>
                        <span>{{ $doctorMedicalRecords->prescription }}</span>
                    </div>

                    <div class="form-group col-auto">
                        <label for="prescription">Laboratory request: </label>
                        <span>{{ $doctorMedicalRecords->laboratory_request }}</span>
                    </div>

                    <div class="form-group col-auto">
                        <label for="prescription">Referral letter: </label>
                        <span>{{ $doctorMedicalRecords->referral_letter }}</span>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <div class="d-flex flex-row-reverse">
        <div><a href="{{ route('doctor.newAppointments') }}" class="btn btn-primary my-2"><i
                    class="fa-solid fa-arrow-left-long mr-2"></i>Back</a></div>
    </div>
    {{-- @else
            <div>
                <p>No data available for current symptoms.</p>
                <!-- Display an appropriate message if the property is not present -->
            </div>
        @endif --}}



@endsection
@section('scriptSource')
    <script></script>
@endsection
