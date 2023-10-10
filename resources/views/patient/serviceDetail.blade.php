@extends('patient.master')
@section('template')
<main id="main">
    <div class="container">
        <div class="row">
        @foreach ($service as $s )
        @if ($s->category_name !== $currentCategory)
            <h3 class="my-3 p-3">{{$s->category_name}}</h3>
            @php
                $currentCategory = $s->category_name
            @endphp

        @endif

            <div class="col-lg-3 col-md-4 d-flex align-items-stretch">
                <div class="card" style="width: 18rem;">
                <img src="{{asset('storage/'. $s->photo)}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">{{$s->name}}</h5>
                  <p class="card-text">{{$s->description}}</p>
                    <button type="button" class="btn btn-sm btn-link clinicDetails" value="{{$s->id}}">View Details</button>
                    <div class="serviceClinicInfo my-2 p-2" style="display: none">
                        <h4 id="price">Price:</h4>
                        <span>Components of the service: </span>
                        <ul id="components"></ul>
                        <span>Available at </span>
                        <h4 id="clinicName" class="my-2"></h4>
                        <h5 id="clinicAddress"></h5>
                        <h5 id="clinicPhone"></h5>

                        <div class="d-grid gap-2 mt-4">
                            <a href="{{route('patient.appointment', $s->id)}}" class="btn btn-info btn-block">Book Service</a>
                        </div>

                    </div>
                </div>

              </div>
              </div>

        @endforeach
    </div>


    </div>
</main>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function () {

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
                        card.find('.serviceClinicInfo #clinicName').text(response.service_data.clinic_name);
                        card.find('.serviceClinicInfo #clinicAddress').text(response.service_data.clinic_address);
                        card.find('.serviceClinicInfo #clinicPhone').text(response.service_data.clinic_phone);
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
      })
</script>
@endsection
