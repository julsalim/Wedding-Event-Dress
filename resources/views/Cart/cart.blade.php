@extends('master')

@section('content')
<br><br><br><br><br>
<div class="container border-bottom">
    <h2 >
        Your Cart ({{ $cart->count() }})

    </h2>
</div>
<div class="container">
    <div class="row p-0 m-0">
        <div class="col-7">
            @foreach ($cart as $item)
            <div class="form-check d-flex align-items-center gap-4 mt-4 border-bottom py-2" id="item-{{ $loop->index }}" name="item-{{ $loop->index }}">
                {{-- <input class="form-check-input border-black check-barang" type="checkbox" value="" id="checkbox-cart-{{ $loop->index }}" name='{{ $loop->index }}'> --}}
    
                <div class="row d-flex align-items-center row-gap-3 w-100">
                    <div class="col-4 col-sm-4 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                        <img src="{{ asset($dresses[$loop->index]->image) }}" alt="" class="w-100 object-fit-cover" id="img-belanja" style="height:8rem;">
                    </div>
    
                    <div class="col-8 col-sm-8 col-md-9 col-lg-9 col-xl-9 col-xxl-9">
                        <div class="d-flex flex-column">
                            <p class="fs-5 m-0 fw-bold">{{ $dresses[$loop->index]->name }}</p>
                            <p class="fs-5 m-0 text-secondary mt-1 mb-2">{{ "Rp ".number_format($dresses[$loop->index]->price, 0, ",", ".") }}</p>

                            
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-danger" onclick="window.location.href = '/delete-cart/{{ $dresses[$loop->index]->id }}'">
                                    <i  class="fas fa-trash"></i>
                                </button>
                            </div>
    
                            {{-- <div class="d-flex flex-row gap-2 rounded-3 bg-white align-items-center" id="stepper">
                                <span type="button" class="input-group-text bg-white border-black lh-sm add-minus" onclick="kurangItem({{ $loop->index }})" id="minus-cart-{{ $loop->index }}" name="{{ $loop->index }}">-</span>
                                <span class="input-group-text bg-white border-black lh-sm" id='jumlah-{{ $loop->index }}'>{{ $k->jumlah }}</span>
                                <span type="button" class="input-group-text bg-white border-black lh-sm add-minus" onclick="tambahItem({{ $loop->index }})" id="add-cart-{{ $loop->index }}" name="{{ $loop->index }}">+</span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-5">
            <div class="container py-4 mt-4" style="border-radius: 4px; background-color: #F1DADF; width: 100%; ">
                <div class="border-bottom border-black ">
                    <span class="modern-font fs-3" style="font-weight: 600">
                        PAYMENT DETAIL
                    </span>
                </div>
                <div class="d-flex" style="font-family: Poppins">
                    <div class="col-6">
                        <p class="mt-3 mb-0" style="font-size: 14px">Subtotal</p>
                    </div>
                    <div class="col-6">
                        <p class="mt-3 mb-0 fw-bold text-end" style="font-size: 14px">{{ "Rp ".number_format($totalPrice, 0, ",", ".") }}</p>
                    </div>
                </div>
                <div class="d-flex m-0">
                    <div class="col-6">
                        <p class="m-0 mb-0" style="font-size: 14px">Admin Fee</p>
                    </div>
                    <div class="col-6">
                        <p class="m-0 mb-0 fw-bold text-end" style="font-size: 14px">Rp 2.500</p>
                    </div>
                </div>

                <div class="d-flex border-top border-black mt-3" >
                    <div class="col-6 mt-3">
                        <p class="m-0 mb-0" style="font-size: 14px">Total</p>
                    </div>
                    <div class="col-6 mt-3">
                        <p class="m-0 mb-0 fw-bold text-end" style="font-size: 14px">{{ "Rp ".number_format($totalPrice + 2500, 0, ",", ".") }}</p>
                    </div>
                </div>

                <div class="w-100 mt-3">
                    <button class="btn buttons" type="button" style="width: 100%" data-bs-target="#pop-up-bayar" data-bs-toggle="modal"  data-bs-dismiss="modal" @if($totalPrice == 0) disabled @endif>Checkout!</button>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bayar-berhasil" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 px-4 pt-4 d-flex align-items-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.reload()"></button>
            </div>

            <div class="modal-body pt-0 px-5 pb-5 d-flex flex-column justify-content-center">
                <i class="display-1 bi bi-check-circle-fill text-center" style="color: #15A824;"></i>
                <p class="modal-title fs-4 fw-bold text-center mt-2 mb-1">Payment Success.</p>
                <p class="model-title text-secondary m-0 text-center">Your order will be proceed shortly.</p>   
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="virtual-acc" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 px-4 pt-4 d-flex align-items-center">
                <button class="btn border-0" data-bs-target="#pop-up-bayar" data-bs-toggle="modal" data-bs-dismiss="modal">
                    <p class="m-0 fs-2 lh-sm p-0">&lt;</p>
                </button>
            </div>

            <div class="modal-body pt-0 px-5 pb-5 d-flex flex-column justify-content-center">
                <p class="modal-title fs-4 fw-bold text-center">Finish your payment</p>
                <p class="model-title text-secondary m-0 text-center">Copy this Virtual Account number to proceed the payments.</p>   
                
                <div class="d-flex flex-row gap-2 my-4 justify-content-center">
                    @php
                    $virtualAccount = "";
                    for ($i = 0; $i < 15; $i++) {
                        $virtualAccount .= rand(0, 9);
                        if ($i % 4 == 3) {
                            $virtualAccount .= " ";
                        }
                    }
                    @endphp
                    <p class="m-0 py-2 px-4 rounded-2 border border-black border-1 bg-white">{{ $virtualAccount }}</p>
                    <button type="button" class="btn buttons" id="btn-bayar" data-bs-toggle="modal" data-bs-target="#bayar-berhasil" onclick="checkout()">Copy</button>
                </div>

                <p class="m-0 pb-1 small text-secondary text-center">Total payment:</p>
                <p class="m-0 fw-bold fs-5 text-center" id='jumlah-bayar-1'>Rp {{ number_format($totalPrice, 0, ",", ".")}}</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pop-up-bayar" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-0 px-5 pb-5 d-flex flex-column justify-content-center">
                <p class="modal-title fs-4 fw-bold text-center">Payments Method</p>
                <p class="model-title text-secondary m-0 text-center mb-2">Choose your payment method</p>                    

                {{-- <div class="d-flex flex-row gap-2 my-4 justify-content-center">
                    <button type="button" class="btn active-btn" id="tf-bank" onclick="pindahPembayaran(2)">@lang('warisan.keranjang.transfer')</button>
                    
                </div> --}}

                <div id="bank mt-2" class="ss">
                    <div type="button" class="d-flex flex-row align-items-center justify-content-between py-3 border-top border-bottom" data-bs-toggle="modal" data-bs-target="#virtual-acc">
                        <div class="d-flex flex-row gap-3 align-items-center">
                            <img src="assets/BCA.png" alt="" width="35px">
                            <p class="m-0">BCA Virtual Account</p>
                        </div>
                        
                        <p class="m-0 fs-4">&gt;</p>
                    </div>

                    <div type="button" class="d-flex flex-row align-items-center justify-content-between py-3 border-bottom" data-bs-toggle="modal" data-bs-target="#virtual-acc">
                        <div class="d-flex flex-row gap-3 align-items-center">
                            <img src="assets/BNI.png" alt="" width="35px">
                            <p class="m-0">BNI Virtual Account</p>
                        </div>
                        
                        <p class="m-0 fs-4">&gt;</p>
                    </div>

                    <div type="button" class="d-flex flex-row align-items-center justify-content-between py-3 border-bottom" data-bs-toggle="modal" data-bs-target="#virtual-acc">
                        <div class="d-flex flex-row gap-3 align-items-center">
                            <img src="assets/BRIVA-BRI.jpg" alt="" width="35px">
                            <p class="m-0">BRI Virtual Account</p>
                        </div>
                        
                        <p class="m-0 fs-4">&gt;</p>
                    </div>

                    <div type="button" class="d-flex flex-row align-items-center justify-content-between py-3 border-bottom" data-bs-toggle="modal" data-bs-target="#virtual-acc">
                        <div class="d-flex flex-row gap-3 align-items-center">
                            <img src="assets/mandiri.webp" alt="" width="35px">
                            <p class="m-0">Mandiri Virtual Account</p>
                        </div>
                        
                        <p class="m-0 fs-4">&gt;</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function checkout() {
        $.ajax({
                type: "POST",
                url: "/checkout",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: "{{ Auth::user()->id } }"
                },
                success: function (response) {
                    // after 5 seconds reload page
                    setTimeout(function() {
                        location.reload();
                    }, 5000);

                },
                error: function (response) {
                    console.log(response);
                }
            });
    }
</script>
@endsection