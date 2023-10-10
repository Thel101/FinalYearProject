@extends('patient.master')
@section('template')
<main id="main">

    <div class="row justify-content-md-center">
        <div class="col col-lg-2">
            <img src="{{asset('storage/'. $doctor->photo)}}" class="img img-fluid rounded-circle">
        </div>
        <div class="col col-lg-8">
            <h4 class="card-title p-2">Dr. {{$doctor->name}}</h4>
            <h5 class="p-2">Specialty: {{$doctor->specialty_name}}</h5>
            <h5 class="p-2">Degree: {{$doctor->degree}}</h5>
            <h5 class="p-2 lh-lg">{{$doctor->experience}}</h5>

            <a class="btn btn-info mt-2 btn-block" href="{{route('patient.docAppointmentPage', $doctor->id)}}">
                    Book appointment
            </a>
        </div>

      </div>


    </div>
        <div class="row mt-3">
            <h3 class="offset-lg-1 mt-5">Other recommended doctors</h3>

                @foreach ($doctors as $d )

                    <div class="offset-lg-1 col-lg-3 col-md-4 d-flex align-items-stretch">
                        <div class="card" style="width: 18rem;">
                        <img src="{{asset('storage/'. $d->photo)}}" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h6 class="p-2 font-weight-bold">{{$d->name}}</h6>
                          <h6 class="p-2">{{$d->degree}}</h6>
                          <h6 class="p-2 lh-lg">{{Str::limit($d->experience,80)}}</h6>
                        </div>

                      </div>
                      </div>

                @endforeach

        </div>


</main>
@endsection
@section('scriptSource')

@endsection
