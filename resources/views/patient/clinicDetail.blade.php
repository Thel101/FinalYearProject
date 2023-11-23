@extends('patient.master')
@section('template')
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">



    <main id="main">

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us">
            <div class="container">

                <div class="row d-flex">
                    <div class="content d-flex">
                        <div class="col-lg-4">
                            <h3>{{ $clinic->name }}</h3>
                            <p><img src="{{ asset('storage/' . $clinic->photo) }}" width="400px" height="200px"></p>
                            <div class="text-center">
                                <a href="#" class="more-btn">Learn More <i class="bx bx-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-7 offset-lg-1" style="margin">
                            <div>
                                <h4>Clinic address</h4>
                                <div class="mt-2">
                                    <h5><i class="fa-solid fa-location-dot p-3"></i></i>{{ $clinic->address }} ,
                                        {{ $clinic->township }}</h5>
                                </div>
                            </div>
                            <div class="mt-2">
                                <h4>Opening hour</h4>
                                <div class="mt-3">
                                    <h5><i class="fa-regular fa-clock p-3"></i>{{ $clinic->opening_hour }} AM -
                                        {{ $clinic->closing_hour }}PM</h5>
                                </div>

                            </div>
                            <div class="mt-2">
                                <h4>Clinic Phone</h4>
                                <div class="mt-3">
                                    <h5><i class="fa-solid fa-phone p-3"></i>{{ $clinic->phone }}</h5>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Why Us Section -->
        <!----Services section--->
        <section class="my-3">
            <h1 class="text-center">Services</h1>

            <div class="card-group">
                @foreach ($services as $index => $service)
                    <div class="col-md-3">
                        <div class="card d-flex flex-column mb-2">
                            <img class="card-img-top" src="{{ asset('storage/' . $service->photo) }}" width="100%"
                                height="200px">
                            <div class="card-body">
                                <h4 class="card-title"><a style="text-decoration : none; color : black"
                                        href="{{ route('patient.serviceDetails', $service->id) }}">{{ $service->name }}</a>
                                </h4>
                                <p class="card-text">{{ $service->description }}</p>
                                <button type="button" class="btn btn-sm btn-link clinicDetails"
                                    value="{{ $service->id }}">View Details</button>
                                <div class="serviceClinicInfo my-2 p-2" style="display: none">
                                    <h4 id="price">Price:</h4>
                                    <span>Components of the service: </span>
                                    <ul id="components"></ul>

                                    <div class="d-grid gap-2 mt-4">
                                        <a href="{{ route('patient.appointment', $service->id) }}"
                                            class="btn btn-info btn-block">Book Service</a>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    @if (($index + 1) % 4 === 0)
                        <div class="row"></div>
                    @endif
                @endforeach
            </div>
        </section>
        <!----Services section--->

        <!----Doctors section--->
        <section class="my-3">
            <h1 class="text-center">Doctors</h1>

            <div class="card-group my-3">
                @foreach ($doctors as $index => $doctor)
                    <div class="col-md-3">
                        <div class="card">
                            {{-- {{$doctor->name}} --}}
                            <div>
                                <a href="{{ route('patient.doctorDetails', $doctor->id) }}"><img
                                        src="{{ asset('storage/' . $doctor->photo) }}" alt="doctor image"
                                        class="rounded-circle my-3 ml-3" width="40%" height="150px"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">{{ $doctor->name }}</h5>
                                <p class="card-text">{{ $doctor->degree }}</p>
                                <p class="card-text">{{ $doctor->experience }}</p>

                            </div>
                        </div>
                    </div>
                    @if (($index + 1) % 4 === 0)
                        <div class="row"></div>
                    @endif
                @endforeach
            </div>
        </section>

        <!----Doctors section--->







        <div class="container">

            <div class="section-title">
                <h2>Gallery</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                    consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                    fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row g-0">

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="#" class="galelry-lightbox">

                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="#" class="galelry-lightbox">

                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="#" class="galelry-lightbox">

                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="#" class="galelry-lightbox">

                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="#" class="galelry-lightbox">

                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="#" class="galelry-lightbox">

                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="#" class="galelry-lightbox">

                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="#" class="galelry-lightbox">

                        </a>
                    </div>
                </div>

            </div>

        </div>




    </main><!-- End #main -->
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('.clinicDetails').click(function(){
            var id= $(this).val();
            var card = $(this).closest('.card');
            $.ajax({
                type: "GET",
                url: "http://127.0.0.1:8000/patient/service/clinic/details/" + id,
                success: function (response) {
                    if (response.service_data !== null) {
                        var componentList = card.find('.serviceClinicInfo #components');
                        var components = response.service_data.components;
                        componentList.empty();
                        card.find('.serviceClinicInfo #price').text("Price : " + response.service_data.price + " MMK");
                        $.each(components, function (index, component) {
                            var li= $('<li>').text(component);
                            componentList.append(li);

                        });
                        card.find('.serviceClinicInfo').toggle();

                    } else {
                        alert('Empty response');
                    }



                }
            });
        })

        });


    </script>
@endsection
