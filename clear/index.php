<?php

require_once 'Game.php';

$game = Game::getInstance();

?>

<!doctype html>

<html lang="en-US">
    <head>
        <title>Checkers</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div id="game">
            <h2>Checkers</h2>
            <p><?= $game->displayMessage() ?></p>

            <form action="index.php">
                <?= $game->printBoard() ?>
                <div id="controls">
                    <input type="submit" name="submit" value="MOVE" />
                    <input type="submit" name="reset" value="NEW GAME" />
                </div>
            </form>
        </div>
    </body>
</html>