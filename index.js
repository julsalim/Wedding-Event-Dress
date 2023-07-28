const express = require('express');
const cors = require('cors');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");

app.use(cors());

const io = new Server(server, {
    cors: {
        origin: '*',
    }
});

const PORT = process.env.PORT || 3000;

let rooms = {}; // Object to store rooms and their information

io.on('connection', (socket) => {
    socket.on('joinRoom', (roomId) => {
        console.log('User joined room ' + roomId);

        if (!rooms[roomId]) {
            rooms[roomId] = {
                users: [],
                turn: 'X',
                board: ['', '', '', '', '', '', '', '', ''],
            };
            io.sockets.emit('turn',{
                turn: rooms[roomId].turn,
                users: rooms[roomId].users,
            });
        } else {
            if (rooms[roomId].users.length >= 2) {
                socket.emit('roomFull');
                console.log('Room is full');
                return;
            }
        }

        socket.join(roomId);
        const newUser = {
            id: socket.id,
            name: 'Player ' + (rooms[roomId].users.length + 1),
            symbol: rooms[roomId].users.length === 0 ? 'X' : 'O',
            number: rooms[roomId].users.length + 1,
        };
        rooms[roomId].users.push(newUser);

        socket.emit('setUser', newUser);

        console.log(rooms[roomId].users.length);

        if (rooms[roomId].users.length === 2) {
            io.to(roomId).emit('start', {
                users: rooms[roomId].users,
                turn: rooms[roomId].turn,
                board: rooms[roomId].board,
            });
            io.to(roomId).emit('turn', {
                turn: rooms[roomId].turn,
                users: rooms[roomId].users,
            });
        }

        socket.emit('start', {
            users: rooms[roomId].users,
            turn: rooms[roomId].turn,
            board: rooms[roomId].board,
        });
    });

    socket.on('move', (data) => {
        const roomId = getRoomId(socket.id);


        if (!roomId) {
            console.log('No room id');
            return;
        }

        const room = rooms[roomId];

        room.board = data.board;

        if (room.turn !== data.turn) {
            return;
        }
        io.to(roomId).emit('move', {
            turn: room.turn,
            board: room.board,
            i: data.i,
        });

        room.turn = room.turn === 'X' ? 'O' : 'X';
        console.log(room.turn);
        room.board = data.board;
        io.to(roomId).emit('turn', {
            turn: rooms[roomId].turn,
            users: rooms[roomId].users,
        });

        // check if there is a winner
        let winner = '';
        for (let i = 0; i < 3; i++) {
            if (room.board[i * 3] !== '' && room.board[i * 3] === room.board[i * 3 + 1] && room.board[i * 3] === room.board[i * 3 + 2]) {
                winner = room.board[i * 3];
            }
            if (room.board[i] !== '' && room.board[i] === room.board[i + 3] && room.board[i] === room.board[i + 6]) {
                winner = room.board[i];
            }
        }
        if (room.board[0] !== '' && room.board[0] === room.board[4] && room.board[0] === room.board[8]) {
            winner = room.board[0];
        }
        if (room.board[2] !== '' && room.board[2] === room.board[4] && room.board[2] === room.board[6]) {
            winner = room.board[2];
        }

        if (winner !== '') {
            io.to(roomId).emit('winner', winner);
        }

        // check if there is a draw
        let draw = true;
        for (let i = 0; i < room.board.length; i++) {
            if (room.board[i] === '') {
                draw = false;
            }
        }
        if (draw) {
            io.to(roomId).emit('winner', 'draw');
        }
    });

    socket.on('disconnect', () => {
        const roomId = getRoomId(socket.id);

        if (!roomId) {
            return;
        }

        const room = rooms[roomId];

        room.users = room.users.filter((user) => user.id !== socket.id);
        console.log(room.users);

        if (room.users.length === 0) {
            delete rooms[roomId];
        } else if (room.users.length === 1) {
            delete rooms[roomId];

            io.to(roomId).emit('resetGame', roomId);
        }
    });

});

function getRoomId(socketId) {
    for (const roomId in rooms) {
        const room = rooms[roomId];
        if (room.users.some((user) => user.id === socketId)) {
            return roomId;
        }
    }
    return null;
}

server.listen(PORT, () => {
    console.log('listening on http://localhost:' + PORT + '/');
});