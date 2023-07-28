let user = null;
let users = [];

let turn = '';
let board = [];
var alreadyWon = 0;
let socket = io('http://localhost:3000', [{
    transports: ['websocket'],
}]);

socket.on('connect', () => {
    document.getElementById('message').innerHTML = 'Connected';
});

socket.on('roomFull', () => {
    document.getElementById('message').innerHTML = 'Room is full';
});

socket.on('setUser', (data) => {
    user = data;
});

socket.on('start', (data) => {
    users = data.users;
    turn = data.turn;
    board = data.board;
    renderBoard();

    if(users.length === 1){
        document.getElementById('message').innerHTML = 'Waiting for another player to join...';
        document.getElementById('board').classList.add('hidden');
    } else {
        document.getElementById('message').innerHTML = 'You are ' + user.symbol + ' and you are player ' + user.number + '';
    }
});

socket.on('turn', (data) => {
    turn = data.turn;

    $.ajax({
        url: '/check-married',
        type: 'GET',
        success: function (response) {
            console.log(response);
            if (response == 1) {
                
                window.location.href = '/';
            }
        }
    });

    if(data.users.length === 1){
        document.getElementById('message').innerHTML = 'Waiting for another player to join...';
        document.getElementById('board').classList.add('hidden');
    } else if (data.users.length === 2) {
        playerTurns = user.symbol == turn ? "<b>your</b>" : turn
        document.getElementById('message').innerHTML = 'You are ' + user.symbol + ', It is ' + playerTurns + ' turn';
        document.getElementById('board').classList.remove('hidden');
    }
});

socket.on('move', (data) => {
    turn = data.turn;
    board = data.board;
    renderBoard();
});

socket.on('winner', (data) => {
    alreadyWon = 1;
    document.getElementById('message').innerHTML = data + ' won';
    document.getElementById('restart-id').style.display = "block";
    
});

socket.on('waiting', () =>{
    console.log('waiting');
});

socket.on('resetGame', (user) => {
    
    users = [user];
    turn = 'X';
    board = ['', '', '', '', '', '', '', '', ''];
    renderBoard();
    document.getElementById('message').innerHTML = 'Another player has left the game! Press restart button below.';
    document.getElementById('restart-id').style.display = "block";
});

socket.on('disconnect', () => {
    document.getElementById('message').innerHTML = 'Disconnected';
});

document.getElementById('join-btn').addEventListener('click', () => {
    document.getElementById('join-btn').disabled = true;
    const roomId = document.getElementById('room').value;
    joinRoom(roomId);
});

function joinRoom(roomId) {
    if (!roomId) {
        document.getElementById('message').innerHTML = 'Invalid Room ID';
        document.getElementById('join-btn').disabled = false;
        return;
    }

    socket.emit('joinRoom', roomId);
}

function renderBoard() {
    let boardDiv = document.getElementById('board');
    let boardHTML = '';
    for (let i = 0; i < board.length; i++) {
        boardHTML += `<div onclick="handleClick(${i})" class="w-32 h-32 text-center text-5xl text-white grid place-content-center border-2 border-black modern-font ${board[i] === 'O' ? 'bgc-plum' : board[i] === 'X' ? 'bgc-periwinkle' : ''}" id='kotak-${board[i]}'>${board[i]}</div>`;
    }
    boardDiv.innerHTML = boardHTML;
}

function handleClick (i) {
    if (board[i] === '' && turn === user.symbol && alreadyWon == 0) {
        board[i] = user.symbol;
        socket.emit('move', {
            turn: turn,
            board: board,
            i: i
        });
    }
}

window.onload = function () {
    renderBoard();
};