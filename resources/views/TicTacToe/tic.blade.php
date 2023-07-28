@extends('master')

@section('content')

    <div class="w-screen h-screen text-center grid place-content-center">
        <h1 class="fs-1 modern-font text-black font-bold">SKY Tic Tac Toe</h1>
        <h1 class="text-sm text-black mb-3" id="message">Server Status : Disconnected</h1>
        <div class="gap-2 w-full h-full grid grid-rows-3 grid-cols-3" id="board" style="background-color: #FAF0F2;">
            <div class="w-32 h-32 text-center text-5xl modern-font text-white grid place-content-center border-2 border-black">X</div>
        </div>
        <input type="hidden" value="{{ $roomId }}" id="room">
        <button class="rounded-full text-white hidden" id="join-btn">Join Room (Enter Room ID)</button>
        <button class="btn buttonss mt-2" type="submit" style="width: 100%; display: none" id="restart-id" onclick="window.location.href='/game-room'"><i class="bi bi-arrow-clockwise"></i> Restart Game</button>
    </div>
    
    <script>
        $(document).ready(function(){
            $('#join-btn').click();

            // before unload
            $(window).bind('beforeunload', function(){
                $.ajax({
                    url: '/restarts-game',
                    type: 'GET'
                });
            });
        });
    </script>
    <script src="{{ asset('js/main.js') }}"></script>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
@endsection