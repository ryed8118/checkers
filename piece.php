<?php

class Piece {

    private $posX;
    private $posY;
    private $pId;
    //private $isKing;
    private $moveX;
    private $moveY;

    public function __construct($x,$y,$direction,$id) {
        $this->moveY = array(-1,1);   // move options on x-axis
        $this->moveX = array($direction); // move options on y-axis
        $this->posX = $x;
        $this->posY = $y;
        $this->pId = $id;
        //$this->isKing = false;
    }

    public function getPosX() {
        return $this->posX;
    }

    public function getPosY() {
        return $this->posY;
    }

    public function getId() {
        return $this->pId;
    }

    public function getDirection() {
        return $this->moveX;
    }

    public function setPos($x,$y) {
        $this->posX = $x;
        $this->posY = $y;
    }

    public function king() {
        $this->moveX = array(-1,1); // piece is able to move positive & negative on y-axis
    }

/*
    public function possibleMoves() {
        foreach ($this->moveY as $dirY) {
            foreach ($this->moveX as $dirX) {
                //$this->moveX;
            }
        }

        if ($this->posX > 8 || $this->posX < 1 || $this->posY > 8 || $this->posY < 1) {
            // Invalid Move!
        }
        //elseif(This Square Is Occupied)
    }

    public function makeKing() {
        $this->moveY = array(-1,1);
    }
*/
} // End class definition