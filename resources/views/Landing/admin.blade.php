@extends('master')

@section('content')
<div class="container">
    <div class="d-flex mt-2 justify-content-center align-items-center">
        <div class="modern-font fs-2">
            Hello, admin!
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn buttons align-self-center ms-1" type="submit">Logout</button>
        </form>
    </div>

    <div class="container">
        @foreach($users as $user)
        <div class="form-check d-flex align-items-center gap-4 mt-4 border-bottom py-2" id="item-{{ $loop->index }}" name="item-{{ $loop->index }}">
            {{-- <input class="form-check-input border-black check-barang" type="checkbox" value="" id="checkbox-cart-{{ $loop->index }}" name='{{ $loop->index }}'> --}}

            <div class="row d-flex align-items-center row-gap-3 w-100">
                <div class="col-4 col-sm-4 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                    <img src="{{ asset('storage/'.$user->profile_picture) }}" alt="" class="w-100 object-fit-cover" id="img-belanja" style="height:8rem;">
                </div>

                <div class="col-8 col-sm-8 col-md-9 col-lg-9 col-xl-9 col-xxl-9">
                    <div class="d-flex flex-column">
                        <p class="fs-5 m-0 fw-bold">{{ $user->name }}</p>
                        <p class="fs-5 m-0 text-secondary mt-1 mb-2">{{ $user->email }}</p>
                        
                        
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn buttons me-2" onclick="window.location.href = '/edit-user/{{ $user->id }}'">
                                Edit User
                            </button>
                            @if ($user->isBanned == 0)
                            <button type="button" class="btn btn-danger" onclick="window.location.href = '/ban/{{ $user->id }}'">
                                Ban User
                            </button>
                            @else
                            <button type="button" class="btn btn-success" onclick="window.location.href = '/unban/{{ $user->id }}'">
                                Unban User
                            </button>
                            @endif
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

</div>
@endsection