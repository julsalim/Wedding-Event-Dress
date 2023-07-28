@extends('master')

@section('content')
<div class="modal fade" id="loginFirst" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 px-4 pt-4 d-flex align-items-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-0 px-5 pb-5 d-flex flex-column justify-content-center">
                <i class="bi bi-person-fill-lock fs-1"></i>
                {{ session()->get('success') }}
            </div>
        </div>
    </div>
</div>


<div class="container w-100 d-flex justify-content-center align-items-center flex-column" style="height: 100vh">
    <div class="container d-flex justify-content-center mb-5">
        <img src="{{ asset('assets/logo.png') }}" alt="" style="width: 100px">
    </div>

    <div class="container fs-3 mb-2 text-center">
        Hello, <span class="fw-bold">{{ $user->name }}</span> ({{ $user->dating_id }})!
    </div>

    <div class="container w-75 p-4" style="background-color: #FAF0F2; border-radius: 12px;">
        
        <div class="d-flex w-100 justify-content-between align-items-center">
            
            <div class="d-flex align-items-center">
                <div class="spinner-border spinner-border-sm me-3" role="status" style="font-size: 12px; aspect-ratio: 1/1">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h4 class="text-center m-0 p-0">                   
                    Waiting for your partner to join the wedding session.
                </h4>
            </div>
            <div>
                <button class="btn buttons align-self-center" type="submit" style="width: 100px;" onclick="window.location.reload()">Refresh</button>
            </div>
        </div>
        <div class="text-wrap text-center mt-5" style="font-size: 14px;">
            Fun fact: While you are waiting, you can play Tic Tac Toe with anyone who is also waiting for their partner to join the wedding session.
        </div>
    </div>

    <div class="container w-100 mt-4 d-flex justify-content-center">
        <button class="btn buttons align-self-center" type="submit" style="width: 200px;" onclick="window.location.href='/game-room'"><i class="bi bi-play-fill"></i> Join Tic-Tac-Toe</button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn buttons align-self-center ms-1" type="submit">Logout</button>


        </form>
    </div>
    
</div>

@if (session()->has('success'))
<script>
    $(document).ready(function(){
        $('#loginFirst').modal('show');
    });
</script>
@endif
@endsection