<?php

require_once('Player.php');
require_once('Piece.php');
require_once('Board.php');
require_once('Square.php');

class Game
{
    private $board;
    private $message;
    private $color;
    private $activeColor;

    protected function __construct()
    {
        $this->startSession();

        $this->message = "Welcome! White's turn!";
        $this->color = 'Red';
        $this->activeColor = 'White';

        if(array_key_exists('submit',$_GET)) {
            $this->checkMove();
        }

    }

    private function startSession()
    {
        session_start();

        if (!isset($_SESSION['b']) || array_key_exists('reset',$_GET)) {
            $this->message = "Start New Game...White's Move";
            $this->board = new Board();
            $_SESSION['b'] = $this->board;
        }else {
            $this->board = $_SESSION['b'];
        }
    }

    public function checkMove()
    {
        if(array_key_exists('piece',$_GET) && array_key_exists('n',$_GET)) {
            $id = $_GET['piece'];
            $moveTo = explode('-',$_GET['n']);
            $x = $moveTo[0];
            $y = $moveTo[1];
            $this->board->setX($x);
            $this->board->setY($y);
            $this->board->setPiece($id);

            $this->changeTurn();
        }else {
            $this->message = "Invalid Move. Try Again.";
        }
    }

    public function changeTurn()
    {
        if($this->board->moveIsValid()=='move') {
            $this->board->setBoard();
            if($this->board->getTurn()=='White') {
                $this->board->setTurn('Red');
            }elseif($this->board->getTurn()=='Red') {
                $this->board->setTurn('White');
            }
            $this->message = $this->board->getTurn() . "'s turn...";
        }elseif($this->board->moveIsValid()=='jump') {
            $this->board->setBoard();
            if($this->board->getTurn()=='White') {
                $this->board->setTurn('Red');
            }elseif($this->board->getTurn()=='Red') {
                $this->board->setTurn('White');
            }
            $this->message = 'Jump! Still ' .$this->board->getTurn() . "'s turn...";
        }else{
            $this->message = 'Invalid Move. Still ' . $this->board->getTurn() . "'s turn...";
        }
    }

    public function displayMessage()
    {
        echo $this->message;
    }

    public function printBoard()
    {
        $this->board->printBoard();
    }

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }
}