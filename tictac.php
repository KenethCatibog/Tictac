<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .board {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            grid-gap: 5px;
            margin: 20px auto;
        }

        .cell {
            width: 100px;
            height: 100px;
            border: 2px solid #333;
            font-size: 24px;
            cursor: pointer;
        }

        .cell:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<?php
$board = [
    ['', '', ''],
    ['', '', ''],
    ['', '', '']
];

$player = 'X';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $row = $_POST['row'];
    $col = $_POST['col'];

    // Check if the cell is empty
    if ($board[$row][$col] === '') {
        $board[$row][$col] = $player;
        // Switch player
        $player = ($player === 'X') ? 'O' : 'X';
    }
}

// Check for a winner
$winner = checkWinner($board);

// Display the board
echo '<h2>Tic Tac Toe</h2>';
echo '<form method="post">';
echo '<div class="board">';
foreach ($board as $rowIndex => $row) {
    foreach ($row as $colIndex => $cell) {
        echo '<div class="cell" onclick="this.parentElement.submit();" name="cell">';
        echo '<input type="hidden" name="row" value="' . $rowIndex . '">';
        echo '<input type="hidden" name="col" value="' . $colIndex . '">';
        echo $cell;
        echo '</div>';
    }
}
echo '</div>';
echo '</form>';

// Display the winner
if ($winner) {
    echo '<h3>' . $winner . ' wins!</h3>';
}

function checkWinner($board)
{
    // Check rows and columns
    for ($i = 0; $i < 3; $i++) {
        if ($board[$i][0] !== '' && $board[$i][0] === $board[$i][1] && $board[$i][1] === $board[$i][2]) {
            return $board[$i][0];
        }
        if ($board[0][$i] !== '' && $board[0][$i] === $board[1][$i] && $board[1][$i] === $board[2][$i]) {
            return $board[0][$i];
        }
    }

    // Check diagonals
    if ($board[0][0] !== '' && $board[0][0] === $board[1][1] && $board[1][1] === $board[2][2]) {
        return $board[0][0];
    }
    if ($board[0][2] !== '' && $board[0][2] === $board[1][1] && $board[1][1] === $board[2][0]) {
        return $board[0][2];
    }

    // Check for a tie
    $isTie = true;
    foreach ($board as $row) {
        foreach ($row as $cell) {
            if ($cell === '') {
                $isTie = false;
                break 2;
            }
        }
    }

    if ($isTie) {
        echo '<h3>It\'s a tie!</h3>';
        exit;
    }

    return null;
}
?>

</body>
</html>
