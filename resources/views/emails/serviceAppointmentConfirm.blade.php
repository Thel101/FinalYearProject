
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
      body, .body {
  margin: 0;
  Margin: 0; // For compatibility with Outlook
  padding: 0;
  border: 0;
  outline: 0;
  width: 100%;
  min-width: 100%;
  height: 100%;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  font-family: $font-family-base;
  line-height: $line-height-base * $font-size-base;
  font-weight: $font-weight-base;
  font-size: $font-size-base;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  background-color: $body-bg;
  color: $body-color;
}

img {
  border: 0 none;
  height: auto;
  line-height: 100%;
  outline: none;
  text-decoration: none;
  display: block;
}

// to fix centering in yahoo
table[align=center] {
  margin: 0 auto;
}

th,
td,
p {
  text-align: left;
  line-height: $line-height-base * $font-size-base;
  font-size: $font-size-base;
  margin: 0;
}

a {
  color: $link-color;
}

    </style>
  </head>
  <body class="bg-light">
    <div class="container">
      <div class="card my-10">
        <div class="card-body">
          <h1 class="h3 mb-2">Appointment Confirmation</h1>
          <h5 class="text-teal-700">Dear {{Auth::user()->name}}</h5>
          <hr>
          <div class="space-y-3">
            <p class="text-gray-700">Thanking you for choosing our service for your healthcare.</p>
            <table>

              <tr>
                <td>Appointment Date</td>
                <td>{{$serviceAppointment->appointment_date}}</td>
              </tr>
              <tr>
                <td>Appointment Time</td>
                <td>{{$serviceAppointment->time_slot}}</td>
              </tr>
              <tr>
                <td>Patient Name</td>
                <td>{{$serviceAppointment->patient_name}}</td>
              </tr>

            </table>

          </div>
          <hr>
          <p class="text-gray-700">We wish the best for your health and hope to see you soon</p>
        </div>
      </div>
    </div>
  </body>

