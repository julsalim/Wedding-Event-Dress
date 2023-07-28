@extends('master')

@section('content')

<div class="modal fade" id="bannedPopup" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 px-4 pt-4 d-flex align-items-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-0 px-5 pb-5 d-flex flex-column justify-content-center">
                <p class="modal-title fs-4 fw-bold text-center mt-2 mb-1">Login unsuccessful</p>
                <p class="model-title text-secondary m-0 text-center">Its seems your account has been banned.</p>   
            </div>
        </div>
    </div>
</div>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">

    
    <div class="container container-box-shadow p-4" style="border-radius: 8px; width: 500px; background-color: #FAF0F2">
        <div class="container d-flex justify-content-center">
            <img src="{{ asset('assets/logo.png') }}" alt="" style="width: 100px">
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Email or Username</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="username" placeholder="jul@salim.com or SKY00101" name="email" required>

                @error('email')
                    <div id="name" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" required>
                @error('password')
                    <div id="name" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @error('email')
                <div id="name" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            @error('password')
                <div id="name" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <div class="w-100 d-flex justify-content-center mt-2">
                <button type="submit" class="btn buttons align-self-center w-100">Login</button>
            </div>
            

        </form>
        
        <div class="mt-3">
            New user around here? Register <a class="text-primary" href="/register" style="text-decoration: underline;">here</a>.
        </div>
    </div>
</div>


@if (Session::has('banned'))
<script>
    $(document).ready(function(){
        console.log('banned')
        $('#bannedPopup').modal('show');
    });
</script>
@endif
@endsection