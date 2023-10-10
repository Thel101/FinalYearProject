@extends('patient.master');
@section('title', 'Appointment Page')
@section('template')
  <main id="main">
    <form action="{{route('service.appointment')}}" class="col-lg-9 col-md-9 offset-2" method="POST" enctype="multipart/form-data">
        @csrf
        <h3>Book your appointment</h3>
        <ol class="step-indicator">
            <li class="active">Step 1</li>
            <li>Step 2</li>
            <li>Step 3</li>
        </ol>
        <div class="card p-3">
            <span class="offset-1 fs-4 my-3">Appointment Type : Medical Service</span>

            <div class="mb-3 row">
                <div class="col-2 offset-lg-1">
                    <label for="service">Medical Service</label>
                </div>
                <div class="col-8">
                    <input id="service" class="form-control" type="text" value="{{$service->name}}" readonly>
                </div>

            </div>
            <div class="mb-3 row">
                <div class="col-2 offset-lg-1">
                    <label for="service">Available Clinic</label>
                </div>
                <div class="col-8">
                    <input id="service" class="form-control" type="text" value="{{$service->clinic_name}}" readonly>
                </div>

            </div>
            <input type="hidden" id="sid" name="serviceId" value="{{$service->id}}">
            <input type="hidden" name="clinicId" value="{{$service->clinic_id}}">
            <input type="hidden" name="discount" value="{{$service->promotion_rate}}">
            <div class="mb-3 row">
                <div class="col-2 offset-lg-1">
                    <label for="price">Service Fees</label>
                </div>
                <div class="col-8">
                    <input name="fees" id="price" class="form-control" type="text" value="{{$service->price}} MMK" readonly>
                </div>

            </div>

            <div class="mb-3 row">
                <div class="col-2 offset-lg-1">
                    <label for="date">Booking Date</label>
                </div>
                <div class="col-8">
                    <input id="date" class="form-control @error('appointmentDate') is-invalid @enderror" type="text" name="appointmentDate">
                    @error('fees')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
                </div>
                <p id="appointmentCount"></p>

            </div>

            <div id="appointmentTime" class="mb-3 row">
                <div class="col-2 offset-lg-1">
                    <label for="time">Booking Time</label>
                </div>
                <div class="row col-8">
                    <div class="row">
                        @foreach ($timeSlots as $slot)
                        <div class="col-md-6">
                            <div class="w-100 p-2 rounded-pill text-center" style="background-color: #eee;">{{ $slot['label'] }}</div>
                            <ul>
                                @php
                                $startTime = \Carbon\Carbon::createFromFormat('H:i', $slot['start']);
                                $endTime = \Carbon\Carbon::createFromFormat('H:i', $slot['end']);
                                // dd($startTime)
                                @endphp

                                 @while ($startTime->lt($endTime))
                                 <li style="list-style: none" class="my-3">
                                    <input class="@error('appointmentTime') is-invalid @enderror" type="radio" name="appointmentTime"
                                    id="time" value="{{ $startTime->format('H:i') }}">
                                   <label for="time">{{ $startTime->format('g:i A') }}</label>
                                    @php
                                        $startTime->addHour(1);
                                    @endphp
                                 </li>

                             @endwhile
                            </ul>
                        </div>


                    @endforeach
                    @error('appointmentTime')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    </div>

                </div>

                </div>

                <div class="mb-3 row">
                    <div class="col-2 offset-lg-1">
                        <label for="refer">Referral Letter</label>
                    </div>
                    <div class="col-8">
                        <input id="refer" class="form-control @error('referral') is-invalid @enderror" type="file" name="referral">
                        @error('referral')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

            </div>

            <div class="d-grid gap-2 mt-4 col-lg-10 col-md-8 offset-lg-1">
                <button type="button" id="bookService" class="btn btn-info btn-block">Book Service</button>
            </div>

            <div id="patientProfile">
                <div class="my-3 row">
                    <span class="offset-1 fs-4 my-3">Patient Profile</span>

                    <div class="col-5 offset-1 form-check">
                        <input class="form-check-input" value="{{Auth::user()->id}}" type="radio" name="patientType" id="self" checked>
                        <label class="form-check-label" for="self">
                          {{Auth::user()->name}}
                        </label>
                      </div>
                      <div class="col-6 form-check">
                        <input class="form-check-input" value="" type="radio" name="patientType" id="others">
                        <label class="form-check-label" for="others">
                          Other Person
                        </label>
                      </div>

                </div>

            </div>
             <!-- for registered patient section-->
            <div id="registeredPatient" class="my-3" >
                <input type="hidden" name="bookingPerson" value="{{Auth::user()->id}}">

                    <div class="mb-3 row">
                        <div class="col-3 offset-lg-1">
                            <label for="time">Patient Name</label>
                        </div>
                        <div class="col-7">
                            <input type="text" class="form-control @error('patientName') is-invalid @enderror" name="patientName" value="{{Auth::user()->name}}">
                            @error('patientName')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="time">Phone Number</label>
                    </div>
                    <div class="col-7">
                        <input type="text" class="form-control @error('patientPhone') is-invalid @enderror" name="patientPhone" id="phone1" value="{{Auth::user()->phone1}}">
                        @error('patientPhone')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="time">Secondary Contact</label>
                    </div>
                    <div class="col-7">
                        <input type="tel" class="form-control @error('patientPhone2') is-invalid @enderror" name="patientPhone2" id="phone2" >
                        @error('patientPhone2')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror

                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="time">Patient Age</label>
                    </div>
                    <div class="col-7">
                        <input type="number" class="form-control @error('patientAge') is-invalid @enderror" name="patientAge" id="age">
                        @error('patientAge')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-grid gap-2 mt-4 col-lg-10 col-md-8 offset-lg-1">
                    <button type="button" class="btn btn-info btn-block confirmProfile">Confirm Profile</button>
                </div>
            </div>
            <!-- for nong-registered patient section-->
            <div class="my-3 row" id="patientProfileForm">
                <input type="hidden" name="bookingPerson" value="{{Auth::user()->id}}">
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="time">Patient Name</label>
                    </div>
                    <div class="col-7">
                        <input type="text" class="form-control @error('patientName') is-invalid @enderror" name="nonRegisterPatientName">
                        @error('patientName')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="time">Phone Number</label>
                    </div>
                    <div class="col-7">
                        <input type="tel" class="form-control @error('patientPhone') is-invalid @enderror" name="nonRegisterPatientPhone" id="phone1">
                        @error('patientPhone')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="time">Secondary Contact</label>
                    </div>
                    <div class="col-7">
                        <input type="tel" class="form-control" name="nonRegisterPatientPhone2" id="phone2" >
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="age">Patient Age</label>
                    </div>
                    <div class="col-7">
                        <input type="number" class="form-control @error('patientAge') @enderror" name="nonRegisterPatientAge" id="age">
                        @error('patientAge')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                </div>
                <div class="d-grid gap-2 mt-4 col-lg-10 col-md-8 offset-lg-1">
                    <button type="button" class="btn btn-info btn-block confirmProfile">Confirm Profile</button>
                </div>
            </div>
            <!-- common health condition section-->
            <div id="healthCondition">
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label>Known Drug Allergy</label>

                    </div>
                    <div class="col-3">
                        <input type="radio" class="form-check-input" name="allergy" id="allergyPresent">
                        <label>Yes</label>
                    </div>
                    <div class="col-3">
                        <input type="radio" class="form-check-input" name="allergy" id="allergyAbsent">
                        <label>No</label>
                    </div>
                </div>
                <div class="col-7 offset-lg-4">
                    <textarea class="form-control"  name="allergy" id="allergyForm" rows="3"></textarea>
                </div>
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label>Underlying Diseases</label>

                    </div>
                    <div class="col-3">
                        <input type="radio" class="form-check-input" name="disease" id="diseasePresent">
                        <label>Yes</label>
                    </div>
                    <div class="col-3">
                        <input type="radio" class="form-check-input" name="disease" id="diseaseAbsent">
                        <label>No</label>
                    </div>
                </div>
                <div class="col-7 offset-lg-4">
                    <textarea class="form-control"  name="disease" id="diseaseForm" rows="3"></textarea>
                </div>

                <div class="d-grid gap-2 mt-4 col-lg-10 col-md-8 offset-lg-1">
                    <button type="submit" class="btn btn-info btn-block">Confirm Appointment</button>
                </div>
            </div>

        </div>

    </form>
  </main>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function(){
        $('#patientProfile').hide();

        $('#nonregisteredPatient').hide();

        $('#serviceForm').hide();

        $('#patientProfileForm').hide();
        $('#registeredPatient').hide();
        $('#healthCondition').hide();
        $('#allergyForm').hide();
        $('#diseaseForm').hide();

        $('input[name="appointmentType"]').change(function () {
            if($(this).is(':checked')){
                $('#serviceForm').toggle();

            }
        })
        $('select[name="selectedCategory"]').change(function(){
            var selectedCategory= $(this).val();
            $.ajax({
            type: "GET",
            url: "http://127.0.0.1:8000/patient/appointment/" + selectedCategory,
            success: function (response) {
               var radiosHtml = '';
               var clinic= '';
               var clinicSet= new Set();
               $.each(response.service_data, function (indexInArray, service) {
                    radiosHtml+=` <div class="col-3">
                        <input class="form-check-input" type="radio" name="selectedService" value="${service.id}">
                            <label class="form-check-label">
                                ${service.name}
                            </label>
                        </div>`;
                        clinicSet.add(service.clinic_id);
               });
            var uniqueClinicNames = Array.from(clinicSet);
            uniqueClinicNames.forEach(function (clinicName) {
            clinic += `<button value="${clinicName}"></button>`;
    });
               $('#medicalService').html(radiosHtml);
               $('#appointmentClinic').html(clinic);
            }

            });
        })

        //date picker
        var currentDate= new Date();
        console.log(currentDate);
        var futureDate= new Date();

        futureDate.setDate(currentDate.getDate()+30);
        $('#date').datepicker({
            minDate: currentDate,
            maxDate: futureDate
        });

        $('#date').change(function(){
            var serviceId= $('#sid').val();
            var date = $(this).val();
            var splitDate = date.split('/'); //09/19/2023  --> 2023-09-25
            var parsedDate= new Date(splitDate[2], splitDate[0]-1, splitDate[1]);
            //change the format of date from date picker to database format
            var formatedDate= parsedDate.getFullYear() + '-' + ('0' + (parsedDate.getMonth()+1)) + '-' + parsedDate.getDate();
            console.log(formatedDate);
            $.ajax({
                type: "GET",
                url: "http://127.0.0.1:8000/patient/date/appointment",
                data: {
                    appointmentDate : formatedDate,
                    service : serviceId
                },
                dataType: "json",
                success: function (response) {
                    if(response.status=='success'){
                        var responseTimeslots = response.timeslot;
                        console.log(responseTimeslots);
                        $('input[name="appointmentTime"]').each(function () {
                        var radioValue = $(this).val();
                            console.log(radioValue);
                        // Check if the radio button's value is in the responseTimeslots array
                        if (responseTimeslots.includes(radioValue)) {
                            // Disable the radio button
                            $(this).prop('disabled', true);
                        }
                    });
                    }
                }
            });
        })
        //show patient profile
        $('#bookService').click(function(){
            $('#patientProfile').show();
        })

        $('#others').click(function () {
            $('#patientProfileForm').show();
            $('#registeredPatient').hide();

        });
        $('#self').click(function () {
            $('#registeredPatient').show();
            $('#patientProfileForm').hide();
          })
        $('.confirmProfile').click(function(){
            $('#healthCondition').show();
        })
        $('#allergyPresent').click(function () {
            $('#allergyForm').show();
        })
        $('#allergyAbsent').click(function () {
            $('#allergyForm').hide();
        })
        $('#diseasePresent').click(function () {
            $('#diseaseForm').show();
        })
        $('#diseaseAbsent').click(function () {
            $('#diseaseForm').hide();
        })
        //step indicator
        // var stepIndicators = $(".step-indicator li");

        // function setActiveStep(stepIndex) {
        //     stepIndicators.each(function (index, step) {
        //         if (index < stepIndex) {
        //             $(step).addClass('completed').removeClass('active');
        //         } else if (index === stepIndex) {
        //             $(step).addClass('active').removeClass('completed');
        //         } else {
        //             $(step).removeClass('active completed');
        //         }
        //     });
        // }

        //     setActiveStep(1);
    })



</script>
@endsection
