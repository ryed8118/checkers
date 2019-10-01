<?php

class Square {

    private $posX;
    private $posY;
    private $occupied;
    private $pieceId;
    private $valid;

    public function __construct($x,$y,$isValid) {
        $this->posX = $x;
        $this->posY = $y;
        $this->occupied = false;
        $this->pieceId = null;
        $this->valid = $isValid;
    }

    public function getPosX() {
        return $this->posX;
    }

    public function getPosY() {
        return $this->posY;
    }

    public function setOccupied($color=false, $id=null) {
        $this->occupied = $color;
        $this->pieceId = $id;
    }

    public function getOccupied() {
        return $this->occupied;
    }

    public function getPieceId() {
        return $this->pieceId;
    }

    public function getValid() {
        return $this->valid;
    }
}