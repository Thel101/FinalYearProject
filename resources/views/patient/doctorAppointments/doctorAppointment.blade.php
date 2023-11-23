@extends('patient.master');
@section('title', 'Appointment Page')
@section('template')
  <main id="main">
    <form action="{{route('doctor.appointment')}}" class="col-lg-9 col-md-9 offset-2" method="POST" enctype="multipart/form-data">
        @csrf
        <h3>Book your appointment</h3>
        <ol class="step-indicator">
            <li class="active">Step 1</li>
            <li>Step 2</li>
            <li>Step 3</li>
        </ol>
        <div class="card p-3">
            <span class="offset-1 fs-4 my-3">Appointment Type : Doctor Consultation</span>

            <input type="hidden" id="DocID" name="docId" value="{{$doctor->id}}">
            <div class="mb-3 row">
                <div class="col-3 offset-lg-1">
                    <label for="service" class="pt-2 text-end">Booking Doctor</label>
                </div>
                <div class="col-8">
                    <div class="ml-1">
                        <input id="service" class="form-control" type="text" value="{{$doctor->name}}" readonly>
                    </div>

                </div>

            </div>
            <div class="mb-3 row">
                <div class="col-3 offset-lg-1">
                    <label for="service" class="pt-2 text-end">Available Clinic</label>
                </div>
                <div class="col-8">
                    <div class="d-grid gap-2" style="grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));">

                        @foreach ($availableClinics as $index=>$c )
                        <div class="col form-check form-check-inline">
                            <input type="radio" class="btn-check" value="{{$c->id}}" name="clinic" id="clinic{{$index}}" autocomplete="off">
                            <label style="width:100%; margin:0; height:1% padding:0" class="btn btn-outline-primary btn-block" for="clinic{{$index}}">{{$c->name}}</label>
                        </div>
                        @endforeach

                    </div>

                </div>

            </div>
            <div id="date" class="mb-3 row">
                <div class="col-3 offset-lg-1">
                    <label for="service" class="pt-2 text-end">Available Date</label>
                </div>
                <div class="col-8">
                    <div class="d-grid gap-2" style="grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));">

                        <div id="dateDisplay" class="col form-check form-check-inline">

                        </div>

                    </div>

                </div>

            </div>
            <div id="timeslots" class="mb-3 row">
                <div class="col-3 offset-lg-1">
                    <label for="slot" class="pt-2 text-end">Available Time Slots</label>
                </div>
                <div class="col-8">
                    <div class="d-grid gap-2" style="grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));">

                        <div id="timeDisplay" class="col form-check form-check-inline">

                        </div>

                    </div>

                </div>

            </div>



            <div id="patientProfile">
                <div class="my-3 row">
                    <span class="offset-1 fs-4 my-3">Patient Profile</span>

                    <div class="col-5 offset-1 form-check">
                        <input class="form-check-input @error('patientType') is-invalid @enderror" value="{{Auth::user()->id}}" type="radio" name="patientType" id="self" checked>
                        <label class="form-check-label" for="self">
                          {{Auth::user()->name}}
                        </label>
                        @error('patientType')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                      </div>
                      <div class="col-6 form-check">
                        <input class="form-check-input @error('patientType') is-invalid @enderror" value="" type="radio" name="patientType" id="others">
                        <label class="form-check-label" for="others">
                          Other Person
                        </label>
                        @error('patientType')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
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
                        <input type="tel" class="form-control @error('patientPhone2') is-invalid @enderror" value="{{old('patientPhone2')}}" name="patientPhone2" id="phone2" >
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
                        <input type="number" class="form-control @error('patientAge') is-invalid @enderror" value="{{old('patientAge')}}" name="patientAge" id="age">
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
                        <input type="text" class="form-control @error('nonRegisterPatientName') is-invalid @enderror" name="nonRegisterPatientName" value="{{old('nonRegisterPatientName')}}">
                        @error('nonRegisterPatientName')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="time">Phone Number</label>
                    </div>
                    <div class="col-7">
                        <input type="tel" class="form-control @error('nonRegisterPatientPhone') is-invalid @enderror" name="nonRegisterPatientPhone" id="phone1" value="{{old('nonRegisterPatientPhone')}}">
                        @error('nonRegisterPatientPhone')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="time">Secondary Contact</label>
                    </div>
                    <div class="col-7">
                        <input type="tel" class="form-control @error('nonRegisterPatientPhone2') is-invalid @enderror" name="nonRegisterPatientPhone2" id="phone2" value="{{old('nonRegisterPatientPhone2')}}" >
                        @error('nonRegisterPatientPhone2')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="age">Patient Age</label>
                    </div>
                    <div class="col-7">
                        <input type="number" class="form-control @error('nonRegisterPatientAge') @enderror" name="nonRegisterPatientAge" value="{{old('nonRegisterPatientAge')}}" id="age">
                        @error('nonRegisterPatientAge')
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
                <div class="mt-3 row">
                    <div class="col-3 offset-lg-1">
                        <label for="">Patient Symptoms</label>
                    </div>
                    <div class="col-7">
                        <textarea class="form-control" name="symptoms" rows="3"></textarea>
                    </div>

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
        $('#timeslots').hide();
        $('#date').hide();
        $('#patientProfile').hide();
        $('#registeredPatient').hide();
        $('#patientProfileForm').hide();
        $('#healthCondition').hide();
        $('#allergyForm').hide();
        $('#diseaseForm').hide();
        var days= ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        $('input[name=clinic]').change(function(){
            $('#date').show();
            $clinicId= $(this).val();
            var schedules= @json($clinicSchedules);

            var schedule_day = schedules[$clinicId];

            var appointment_day = [];

            var index = schedule_day.length;

            for(let i=0; i<index; i++){
                var schedule_days =schedule_day[i].scheduleDay;
                console.log(schedule_days);
                if(days.includes(schedule_days)){
                   var day_index= days.indexOf(schedule_days);
                   appointment_day.push(day_index);
                }
            }
            var date, currentDay, daysUntilNext,nextDate,secondNextDate,formattedDate,secondFormattedDate;
            var day_count= appointment_day.length;

            var nearestDates=[];
            for(var a=0; a<day_count; a++){
                //function to format date
                function formatDate(date) {
                var monthName = date.toLocaleString('en-US', { month: 'short' });
                var dayOfMonth = date.getDate();
                var year = date.getFullYear();
                return monthName + ' ' + dayOfMonth + ' ' + year;

            }
                if(appointment_day[a]===1){
                    date= new Date();
                    currentDay = date.getDay();
                    daysUntilNext = (7 - currentDay + 1) % 7;
                    //first week nearest date
                    nextDate = new Date(date);
                    nextDate.setDate(date.getDate() + daysUntilNext);
                    formattedDate = formatDate(nextDate);
                    //second week nearest date
                    secondNextDate = new Date(nextDate);
                    secondNextDate.setDate(nextDate.getDate()+7);
                    secondFormattedDate = formatDate(secondNextDate);
                    nearestDates.push(formattedDate, secondFormattedDate);
                    console.log(nearestDates);

                }
                else{
                    date= new Date();
                    currentDay = date.getDay();
                    if (currentDay < appointment_day[a]) {
                        daysUntilNext = appointment_day[a] - currentDay;
                    } else if (currentDay > appointment_day[a]) {
                        daysUntilNext = 7 - (currentDay - appointment_day[a]);
                    }
                    nextDate = new Date(date);
                    console.log(nextDate);
                    nextDate.setDate(date.getDate() + daysUntilNext);
                    formattedDate = formatDate(nextDate);
                    secondNextDate = new Date(nextDate);
                    secondNextDate.setDate(nextDate.getDate()+7);
                    secondFormattedDate = formatDate(secondNextDate);
                    nearestDates.push(formattedDate, secondFormattedDate);
                }
            }
            $('#date').show();
            var newDiv =$('#dateDisplay');
            newDiv.empty();
            for(var i=0; i<nearestDates.length; i++){
                var radioId= "date" +i
                var radioInput = $("<input>").attr({
                type: "radio",
                class: "btn-check",
                value: nearestDates[i],
                name: "scheduleDate",
                id: radioId,
                autocomplete: "off"
            });

            // Create a new label element
            var labelElement = $("<label>").addClass("btn btn-outline-info btn-block m-2").attr({
                for: radioId,
            }).text(nearestDates[i]);


            // Append the radio input and label to the div
            newDiv.append(radioInput, labelElement);
            }


        });
        $(document).on("change", "input[type='radio'][name='scheduleDate']", function() {
        // document is need for dynamically added elements
        var selectedDate = $(this).val(); // Get the value of the clicked radio button
        var clinicId= $("input[type='radio'][name='clinic']:checked").val();
        // console.log(clinicId);
        var docId= $('#DocID').val();


        $.ajax({
            type: "GET",
            url: "http://127.0.0.1:8000/patient/doctors/availability",
            data: {
                clinic : clinicId,
                appointmentDate : selectedDate,
                doctor: docId
            },
            dataType: "json",
            success: function (response) {
                if(response.status=='success'){
                    var timeslots = response.timeslots;
                    var bookedSlots = response.bookedTimes;
                    console.log(timeslots);
                    $('#timeslots').show();

                    var timeDiv= $('#timeDisplay');
                    timeDiv.empty();

                    for(var a=0; a<timeslots.length; a++){
                    var timeRadioId= "time" + a;
                    var timeRadioValue = timeslots[a];
                    var timeRadioInput = $("<input>").attr({
                    type: "radio",
                    class: "btn-check",
                    value: timeRadioValue,
                    name: "availableTime",
                    id: timeRadioId,
                    autocomplete: "off"
                    });
                    var timeLabelElement = $("<label>").addClass("btn btn-outline-info btn-block m-2").attr({
                    for: timeRadioId,
                    }).text(timeslots[a]);

                    timeDiv.append(timeRadioInput, timeLabelElement);
                    console.log(timeRadioValue);
                    if(bookedSlots.includes(timeRadioValue))
                    {
                        $('input[name="availableTime"][value="' + timeRadioValue + '"]').prop('disabled', true);
                    }
            }



            }
            }
        });
        });

        $(document).on("change", "input[type='radio'][name='availableTime']", function() {
            $('#patientProfile').show();
        });
        $('input[name=patientType]').click(function(){
            $('#registeredPatient').show();
        });
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
    });



</script>
@endsection
