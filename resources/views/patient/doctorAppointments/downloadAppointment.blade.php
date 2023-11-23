<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="card-body">

        <div>
            <h1 class="text-primary">Poly Clinic Appointment System</h1>
        </div>

    <h4 class="card-title font-bold mt-lg-5 lh-lg">Dear {{$appointmentData->user_name}}, this is your appointment details for</h4>
    <div class="offset-lg-1 p-2">
        <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead lh-lg">Appointment Date : {{$appointmentData->appointment_date}}</span></div>

        <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead lh-lg">Appointment Time : {{$appointmentData->time_slot}}</span></div>

      </div>
    <hr><hr>
    <div class="offset-lg-1 p-2">
      <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead lh-lg">Doctor : {{$appointmentData->doctor_name}}</span></div>

      <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead lh-lg">Clinic : {{$appointmentData->clinic_name}}</span></div>
      <div class="col-lg-6 col-md-4 my-1"> <span class="card-text lead lh-lg">Location : {{$appointmentData->clinic_address}} ,{{$appointmentData->clinic_township}}</span></div>
    </div>
    <hr>
    <div class="offset-lg-1 p-2">
        <div class="lead">Patient Information</div>
        <div>
            <span class="lh-lg" style="font-style: bold; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Patient Name: </span>
            <span>{{$appointmentData->patient_name}}</span>
        </div>
        <div>
            <span class="lh-lg" style="font-style: bold; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Patient Age: </span>
            <span>{{$appointmentData->patient_age}} yrs old</span>
        </div>
        <div>
            <span class="lh-lg" style="font-style: bold; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Phone Number: </span>
            <span>{{$appointmentData->phone_1}}, {{$appointmentData->phone_2}}</span>
        </div>
        <div>
            <span class="lh-lg" style="font-style: bold; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Symptoms: </span>
            <span>{{$appointmentData->symptoms}}</span>
        </div>
        <div>
            <span class="lh-lg" style="font-style: bold; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Allergy: </span>
            <span>{{$appointmentData->allergy}}</span>
        </div>
        <div>
            <span class="lh-lg" style="font-style: bold; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Disease: </span>
            <span>{{$appointmentData->disease}}</span>
        </div>

    </div>

    <hr>
    <div class="offset-lg-1 p-2">
        <div class="lead">Consultation Fees Information</div>
        <div>
            <span class="lh-lg" style="font-style: bold; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Consultation fees: </span>
            <span>{{$appointmentData->doctor_fees}} MMKs</span>
        </div>
        <div>
            <span class="lh-lg" style="font-style: bold; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Clinic Charges: </span>
            <span>{{$appointmentData->clinic_charges}} MMKs</span>
        </div>
        <div>
            <span class="lh-lg" style="font-style: bold; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Total Charges: </span>
            <span>{{$appointmentData->total_fees}} MMKs</span>
        </div>
    </div>
<hr>
    <div class="offset-lg-1 p-2">
        <span style="font-style: bold">We will be looking forward to your attendance soon</span>
        <div class="text-primary lh-lg">Yours sincerely,</div>
        <div class="text-primary">Poly Clinic Appointment Team</div>

    </div>



  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

