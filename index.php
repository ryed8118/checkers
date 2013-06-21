<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('player.php');
require_once('piece.php');
require_once('board.php');


session_start();

$message = "&nbsp;";
$color = 'Red';
$activeColor = 'White';

if (!isset($_SESSION['b']) || array_key_exists('reset',$_GET)) {
    // Start a new game
    $message = "Start New Game...White's Move";
    $b = new Board();
    $_SESSION['b'] = $b;
}else {
    // Resume game already in progress
    $b = $_SESSION['b'];
}

if(array_key_exists('submit',$_GET)) {

    if(array_key_exists('piece',$_GET) && array_key_exists('n',$_GET)) {
        $id = $_GET['piece'];
        $moveTo = explode('-',$_GET['n']);
        $x = $moveTo[0];
        $y = $moveTo[1];
        $b->setX($x);
        $b->setY($y);
        $b->setPiece($id);
        if($b->moveIsValid()=='move') {
            $b->setBoard();
            if($b->getTurn()=='White') {
                $b->setTurn('Red');
            }elseif($b->getTurn()=='Red') {
                $b->setTurn('White');
            }
            $message = $b->getTurn() . "'s turn...";
        }elseif($b->moveIsValid()=='jump') {
            $b->setBoard();
            if($b->getTurn()=='White') {
                $b->setTurn('Red');
            }elseif($b->getTurn()=='Red') {
                $b->setTurn('White');
            }
            $message = 'Jump! Still ' .$b->getTurn() . "'s turn...";
        }else{
            $message = 'Invalid Move. Still ' . $b->getTurn() . "'s turn...";
        }


    }else {
        $message = "Invalid Move. Try Again.";
    }
}

?>


<!doctype html>

<html>

    <head>

        <title>Checkers</title>
        <meta charset="utf-8" />

        <style>
            table { border: solid #000000 thin; width: 500px; height: 500px; margin-left: auto; margin-right: auto; }
            td { border: solid #000000 thin; background-color: #CCCCCC; }
            .red { background-color: #FF0000; }
            .white { background-color: #FFFFFF; }
            .black { background-color: #000000; }
            #left { display: inline-block; float: left; width: 400px; }
            #game { text-align: center; }
            #controls { margin: 10px; font-size: 15px; }
            input[type=submit] { padding: 5px; margin: 5px; width: 100px; }
            input[type=checkbox] { border-radius: 5px; width: 20px; height: 20px; }
        </style>

    </head>

    <body>

        <div id="left">
            <?php
                echo '<pre>';
                var_dump($b);
                echo '</pre>';
            ?>
        </div><!-- #left -->

        <div id="game">

            <h2>Checkers</h2>
            <p><?php echo $message; ?></p>

            <form action="index.php">

                <?php

                /*
                 * PRINT BOARD:
                 */
                    $b->printBoard();

                ?>

                <div id="controls">
                    <input type="submit" name="submit" value="MOVE" />
                    <input type="submit" name="reset" value="NEW GAME" />
                </div><!-- #controls -->

            </form>

        </div><!-- #game -->

    </body>

</html>