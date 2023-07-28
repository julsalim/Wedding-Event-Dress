board = ['', '', '', '', '', '', '', '', ''];
turn = '';

// randomize who goes first
turn = Math.random() < 0.5 ? 'X' : 'O';

function renderBoard() {
    let boardDiv = document.getElementById('board');
    let boardHTML = '';
    for (let i = 0; i < board.length; i++) {
        boardHTML += `
        <div onclick="handleClick(${i})" class="col border border-5 border-secondary p-5 ${board[i] === 'O' ? 'bg-success' : board[i] === 'X' ? 'bg-danger' : ''}">
            <h2 class="text-center text-white">${board[i]}</h2>
        </div>`;
    }
    boardDiv.innerHTML = boardHTML;
}

function handleClick(i) {
    if (board[i] == '') {
        board[i] = turn;
        renderBoard();
        // checkWin();
        turn = turn == 'X' ? 'O' : 'X';
        document.getElementById('message').innerHTML = `Player ${turn}'s turn!`;
    }
}

window.onload = function () {
    document.getElementById('message').innerHTML = `Player ${turn} goes first!`;
    renderBoard();
}