<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    
    <title>SKY Wedding</title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sacramento&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;300;400&display=swap');
    </style>
</head>
<body>
    @if (Route::currentRouteName() == 'landing' || Route::currentRouteName() == 'cart')
    <nav class="position-fixed z-3 w-100" id="navbar" style="top: 0; @if(Route::currentRouteName() == 'cart') background-color: #F1DADF @endif">
        <div class="container-fluid">
            <div class="row d-flex flex-row align-items-center py-3 px-5" id="navbar-row">
                <div class="col-1 col-sm-3 col-md-3 col-lg-5 col-xl-5 col-xxl-5 justify-content-start p-0 d-flex flex-row gap-4 align-items-center position-relative">
                    <div class="dropdown d-none" id="burger">
                        <button class="btn btn-sm border-0 p-0" id="burgericon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list text-white fs-4"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" id="burger-menu">
    
                        </ul>
                    </div>
    
                    <a href="/" id="logo-1"><img src={{ asset("assets/logo.png") }} alt="" id="logo-navbar-1"></a>
                    <a href="/" id="logo-2"><img src={{ asset("assets/logo.png") }} alt="" id="logo-navbar-2"></a>

                </div>
    
                <div class="col-11 col-sm-9 col-md-9 col-lg-7 col-xl-7 col-xxl-7 d-flex flex-row align-items-center justify-content-end gap-4">
                     
                    <a href="/cart"><i @if (Route::currentRouteName() == 'cart') class="fs-4 bi bi-cart-fill" @else class="fs-4 bi bi-cart" @endif id="carts"  @if(Route::currentRouteName() == 'cart') style = "color:black" @endif style="color:white"></i></a>
    
    
                    <div class="dropdown">
                        <button class="btn btn-sm border-0 p-0" id="profilebtn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{-- @auth
                            @php
                                $bools = str_contains($profilePicture, 'http')
                            @endphp
                                @if ($bools)
                                <img src="{{ $profilePicture }}" alt="" class="rounded-circle" id="img-profile" referrerPolicy="no-referrer">
                                @else
                                <img src="{{ asset($profilePicture) }}" alt="" class="rounded-circle" id="img-profile" referrerPolicy="no-referrer">
                                @endif
                            @else
                                <i class="bi bi-person-circle fs-4 text-white"></i>
                                @endauth --}}
                                <i class="bi bi-person-circle fs-4" id='profiles' @if(Route::currentRouteName() == 'cart') style = "color:black" @endif style="color:white"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            @auth
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <li><a class="dropdown-item small" href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">Logout</a></li>
    
                                </form>
                            @else
                                <li><a class="dropdown-item small" href="/login">Masuk Akun</a></li>
                            @endauth
                        </ul>
                    </div>
    
                    <div class="d-none">
                        <input type="checkbox" id="check" class="d-none">
                        <label for="check"><i class="fs-3 bi bi-list text-white d-none"></i></label>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    @endif

    @yield('content')
    
</body>
</html>