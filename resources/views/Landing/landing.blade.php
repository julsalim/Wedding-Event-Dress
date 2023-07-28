@extends('master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />






<div class="background-landing" role='banner' style="height:100vh; background-image: url({{ asset('assets/background-1.jpg') }}); background-size: cover; background-repeat: no-repeat;">
    <div class="d-flex justify-content-center align-items-center wedding-cover" style="height: inherit;">
        <div class="wedding-text text-center" style="font-family: Sacramento; font-size: 60px">
            Where Love Meets Elegance: Creating Forever Moments in Wedding Dresses
        </div>
    </div>
</div>

<div class="container-fluid d-flex flex-column">

    <div class="container my-2 modern-font py-4 w-50" style="background-color: #FAF0F2; color: black; font-weight: 600; border-radius: 8px">
        <div class="fs-4 text-center d-flex justify-content-center">
            <img class="align-self-end" src="https://wedsites.s3.amazonaws.com/accounts/3812/header/1037/branding-1614172984.png" style="width: 20px; height: 15px" alt="">
            YOUR PARTNER TO CREATE FOREVER MOMENTS <img src="https://wedsites.s3.amazonaws.com/accounts/3812/header/1037/branding-1614172984.png" style="width: 20px; height: 15px" alt="">
        </div>

        <div class="d-flex mt-3 align-items-center flex-column">
            <img src="{{ asset('storage/'.$partner->profile_picture) }}" alt="" style="height: 170px; width: 150px; object-fit: cover; border-radius: 4px">
            <h5 class="p-0 m-0 modern-font mt-2">
                {{ $partner->name }}
            </h5>
        </div>

    </div>

    
    <div class="text-center modern-font fs-1 mt-5">
        All Products
    </div>

    <div class="d-flex justify-content-center align-items-center mb-2">
        <div style="width: fit-content" class="me-1 modern-font">
            Filter :
        </div>
        <select class="form-select container border-secondary w-auto m-0 modern-font" id="location" style="height: fit-content">
            <option value="0">All Locations</option>
            @foreach ($location as $loc)
                <option value="{{ $loc->id }}">{{ $loc->name }}</option>
            @endforeach
        </select>
    </div>

    

    <section class="section-products">
		<div class="container">
				<div class="row" id='tempat-dress'>
                    @foreach ($dresses as $dress)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div id="product-{{ $loop->index }}" class="single-product">
                            <div class="part-1">
                                <span class="new">{{ $dress->gender == "1" ? "Male" : "Female" }}</span>
                                <span class="discount">{{ ($dress->location_id == "1") ? "Tangerang" : ($dress->location_id == "2" ? "Singapore" : "Jakarta")}}</span>
                                    <ul>
                                            <li><a onclick="addToCart({{ $dress->id }})"><i class="fas fa-shopping-cart"></i></a></li>
                                    </ul>
                            </div>
                            <div class="part-2">
                                    <h3 class="product-title">{{ $dress->name }}</h3>
                                    <h4 class="product-price">Rp {{ number_format($dress->price, 0, ",", ".")}}</h4>
                                    {{-- <h4 class="product-price">$49.99</h4> --}}
                            </div>
                        </div>
                    </div>

                    <style>
                        .section-products #product-{{ $loop->index }} .part-1::before {
                            background: url("{{ $dress->image }}") no-repeat center;
                            background-size: cover;
                        }
                    </style>
                    @endforeach
						
				</div>
		</div>
    </section>

</div>




<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="liveToast">
        <div class="d-flex">
            <div class="toast-body">
                Items added to cart!
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    const toastTrigger = document.getElementById('liveToastBtn')
    const toastLiveExample = document.getElementById('liveToast')

    if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
        })
    }
</script>



<script>
    

    window.onscroll = function () {
        scrollfunction();
    }

    function scrollfunction() {
        if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
            document.getElementById("navbar").style.backgroundColor = "#F1DADF";
            document.getElementById("profilebtn").style.backgroundColor = "#F1DADF";
            document.getElementById('carts').style.color = "black";
            document.getElementById('profiles').style.color = "black";
        } else {
            document.getElementById("navbar").style.backgroundColor = "transparent";
            document.getElementById("profilebtn").style.backgroundColor = "transparent";
            document.getElementById('carts').style.color = "white";
            document.getElementById('profiles').style.color = "white";
        }
    }
</script>

<script>
    $(document).ready(
            function () {
                $('#location').on('change', function (){
                    var locationId = $(this).val();


                    // fill #tempat-dress with circular loading
                    $('#tempat-dress').html(`
                    <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    `);

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "/location-filter",
                        type: "POST",
                        data: {
                            locationId : locationId
                        },
                        success: function (data) {
                            $('#tempat-dress').html(data);
                        },
                        error: function (data) {
                            console.log(data);
                        }

                    });
                });
            })
</script>

<script>
    function addToCart (id) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/add-to-cart",
            type: "POST",
            data: {
                dressId : id,
                userId : {{ Auth::user()->id }}
            },
            success: function (data) {
                
                const toastLiveExample = document.getElementById('liveToast')
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                toastBootstrap.show()
                
                console.log(data);
                $('#cart-count').html(data);
            },
            error: function (data) {
                console.log(data);
            }

        });
    }
</script>

@endsection