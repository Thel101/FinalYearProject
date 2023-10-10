@extends('patient.master')
@section('title', 'Registration Page')
@section('template')
  <main id="main">

    <form action="{{route('patient.add')}}" method="POST">
        @csrf
        <div class="col-lg-6 offset-3">
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('patientName') is-invalid @enderror" id="floatingInput" placeholder="name" name="patientName" value="{{old('patientName')}}">
                <label for="floatingInput">Name</label>

                @error('patientName')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('patientName') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name="patientEmail" value={{old('patientEmail')}}>
                <label for="floatingInput">Email address</label>
                @error('patientName')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>

              <div class="form-floating mb-3">
                <input type="tel" class="form-control @error('patientPhone') is-invalid @enderror" id="floatingInput" placeholder="phone number" name="patientPhone" value={{old('patientPhone')}}>
                <label for="floatingInput">Phone</label>
                @error('patientPhone')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control @error('patientAddress') is-invalid @enderror" id="floatingInput" placeholder="address" name="patientAddress" value={{old('patientAddress')}}>
                <label for="floatingInput">Address</label>
                @error('patientAddress')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>

              <div class="form-floating">
                <input type="password" class="form-control @error('patientPassword') is-invalid @enderror" id="floatingPassword" placeholder="Password" name="patientPassword" value={{old('patientPassword')}}>
                <label for="floatingPassword">Password</label>
                @error('patientPassword')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>

              <div class="form-group mt-2">
                <button type="submit" class="btn btn-block btn-primary w-100">Sign Up</button>
              </div>

              <div class="form-group mt-2">
                Already have an account? <a href="{{route('login')}}">Log in here</a>
              </div>
        </div>

    </form>



  </main>
@endsection
