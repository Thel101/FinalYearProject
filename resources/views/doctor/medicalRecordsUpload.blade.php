@extends('doctor.doctorDashboard')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        @if (session('uploadedRecord'))
            <div>
                <form>
                    @csrf

                    <div class="form-group">
                        <label for="name">Patient Information</label>
                        <span class="d-block">{{ session('appointmentInfo')->patient_name }}</span>
                        <span class="d-block">{{ session('appointmentInfo')->patient_age }}</span>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="age">Current symptoms</label>
                        <span class="d-block">{{ session('uploadedRecord')->current_symptoms }}</span>
                    </div>
                    <hr>
                    <div class="form-group col-auto">
                        <label for="phone">General Medical History</label>
                        <span>{{ session('uploadedRecord')->medical_history }}</span>
                    </div>

                    <div class="form-group col-auto">
                        <label for="phone">Family History</label>
                        <span>{{ session('uploadedRecord')->family_history }}</span>
                    </div>

                    <div class="form-group col-auto">
                        <label for="phone">Surgical History</label>
                        <span>{{ session('uploadedRecord')->surgery_history }}</span>
                    </div>

                    <div class="form-group my-2">
                        <label for="prescription">Prescription</label>
                        <span>{{ session('uploadedRecord')->prescription }}</span>
                    </div>

                </form>
            </div>
        @else
            <div>
                <p>No data available for current symptoms.</p>
                <!-- Display an appropriate message if the property is not present -->
            </div>
        @endif
    @else
        <div class="card">
            <div class="card-header">
                <h4 class="mt-3">Patient medical records form</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('doctor.postRecords') }}">
                    @csrf
                    <div class="form-row">
                        <input type="hidden" name="appointmentID" value="{{ $appointment->id }}" />
                        <div class="form-group col-md-4">
                            <label for="name">Patient Name</label>
                            <input name="patientName" type="text" class="form-control" id="name"
                                value="{{ $appointment->patient_name }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="age">Patient Age</label>
                            <input name="patientAge" type="number" class="form-control" id="age"
                                value="{{ $appointment->patient_age }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone">Phone number</label>
                            <input name="patientPhone" type="text" class="form-control" id="phone"
                                value="{{ $appointment->phone_1 }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Patient Symptoms</label>
                        <textarea name="currentSymptoms" type="text" class="form-control" id="address"> {{ $appointment->symptoms }}</textarea>
                    </div>

                    <div class="row" id="medicalHistory">
                        <label>Past Medical History</label>
                        <div class="col-auto">
                            <div class="form-check">
                                <input name="medicalHistory[]" class="form-check-input" style="display: none"
                                    type="checkbox" value="hypertension" id="hypertension">
                                <label class="form-check-label btn btn-outline-primary" for="hypertension">
                                    Hypertension
                                </label>

                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input name="medicalHistory[]" class="form-check-input" style="display: none"
                                    type="checkbox" value="asthma" id="asthma">
                                <label class="form-check-label btn btn-outline-primary" for="asthma">
                                    Asthma
                                </label>

                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input name="medicalHistory[]" class="form-check-input" style="display: none"
                                    type="checkbox" value="diabetes" id="diabetes">
                                <label class="form-check-label btn btn-outline-primary" for="diabetes">
                                    Diabetes
                                </label>

                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input name="medicalHistory[]" class="form-check-input" style="display: none"
                                    type="checkbox" value="cardiac" id="cardiac">
                                <label class="form-check-label btn btn-outline-primary" for="cardiac">
                                    Cardiac Diseases
                                </label>

                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" style="display: none" type="checkbox" value=""
                                    id="others">
                                <label class="form-check-label btn btn-outline-primary" for="others">
                                    Others
                                </label>

                            </div>
                        </div>
                    </div>


                    <div class="form-group my-2">
                        <label for="surgery">Family History</label>
                        <textarea name="familyHistory" type="text" class="form-control" id="family"
                            placeholder="Describe family history"></textarea>
                    </div>

                    <div class="form-group my-2">
                        <label for="surgery">Past Surgery History</label>
                        <textarea name="surgeryHistory" type="text" class="form-control" id="surgery"
                            placeholder="Describe previous operations received."></textarea>
                    </div>

                    <div class="form-group my-2">
                        <label for="prescription">Prescription</label>
                        <textarea name="prescription" rows="3" type="text" class="form-control" id="prescription"></textarea>
                    </div>
                    <div class="form-group my-2">
                        <label for="labRequest">Laboratory Request</label>
                        <textarea name="laboratory" rows="3" type="text" class="form-control" id="labRequest"></textarea>
                    </div>

                    <div class="form-group my-2">
                        <label for="referral">Referral Letter</label>
                        <textarea name="referral" type="text" class="form-control" id="referral"></textarea>
                    </div>

                    <div class="d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-primary my-2">Upload Record</button>
                    </div>

                </form>
            </div>
        </div>
    @endif
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                if ($(this).prop("checked")) {
                    $(this).next('label').removeClass('btn-outline-primary btn-outline-dark').addClass(
                        'btn-primary');
                } else {
                    $(this).next('label').removeClass('btn-primary').addClass('btn-outline-dark');
                }

            });
            const medicalHistory = $('#medicalHistory');
            const newHistory = $('<div>').html(`
                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <label for="othersHistory">Specify the medical condition</label>
                                <textarea name="medicalHistory[]" type="text" class="form-control" id="othersHistory"></textarea>
                            </div>
                        </div>
                        `);
            $('#others').change(function() {
                if ($(this).prop("checked")) {
                    $(medicalHistory).append(newHistory);
                } else {
                    newHistory.remove();
                }
            })
        });
    </script>
@endsection
