@extends('doctor.doctorDashboard')
@section('content')

@if (session('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('message') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div class="col-md-10 offset-1">
        <form action="{{ route('doctor.profileEdit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- general form elements -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Doctor Log-in Information</h3> </i>
                </div>
                <!-- /.card-header -->

                <!-- form start -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ asset('storage/' . $doc->photo) }}" class="img img-thumbnail">
                        </div>
                        <input type="hidden" name="docID" value="{{ $doc->id }}">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="docDegree">Doctor Photo</label>
                                <input type="file" name="photo" class="form-control" id="docPhoto">
                            </div>
                            <div class="form-group">
                                <label for="docName">Doctor name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Enter doctor name" value="{{ $doc->name }}">
                            </div>

                            <div class="form-group">
                                <label for="docLicense">License Number</label>
                                <input type="text" name="license" class="form-control" id="docLicense"
                                    value="{{ $doc->license_no }}">
                            </div>

                            <div class="form-group">
                                <label for="docEmail">Email address</label>
                                <input type="email" name="email" class="form-control" id="docEmail"
                                    value="{{ $doc->email }}">
                            </div>



                        </div>
                    </div>
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="docPhone">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" id="docPhone"
                                    value="{{ $doc->phone }}">
                            </div>
                            <div class="form-group">
                                <label>Specialty</label>
                                <select class="form-select" aria-label="Default select example" name="specialty">
                                    <option value="{{$doc->specialty_id}}">{{$doc->specialty_name}}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="docDegree">Doctor Degree</label>
                                <input type="text" name="degree" class="form-control" id="docDegree"
                                    value="{{ $doc->degree }}" readonly>
                            </div>

                            <div>
                                <label>Doctor Scheduless</label>
                                <table class="table table-borderless">
                                    <th>Schedule Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    @foreach ($doc->clinics as $clinic)
                                        <tr>
                                            <td>{{ $clinic->pivot->schedule_day }} </td>
                                            <td> {{ $clinic->pivot->start_time }}</td>
                                            <td>{{ $clinic->pivot->end_time }}</td>
                                        </tr>
                                    @endforeach
                                </table>

                            </div>
                        </div>
                        <div class="col-6">

                            <div class="form-group">
                                <label for="docFees">Consultation Fees</label>
                                <input type="number" name="fees" class="form-control" id="docFees"
                                    value="{{ $doc->consultation_fees }}">
                            </div>

                            <div class="form-group">
                                <label for="docEmail">Consultation Duration</label>
                                <input type="text" name="duration" class="form-control"
                                    value="{{ $doc->consultation_duration }}" id="docDuration">
                            </div>
                            <div class="form-group">
                                <label for="docExperience">Experience</label>
                                <input type="text" name="experience" class="form-control" id="docExperience"
                                    value="{{ $doc->experience }}" readonly>
                            </div>



                        </div>


                    </div>

                </div>
                <div class="row">
                    <div class="col-8 offset-2">
                        <button type="submit" class="btn btn-success mb-2">Update Doctor</button>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>




        </form>
    </div>
@endsection
