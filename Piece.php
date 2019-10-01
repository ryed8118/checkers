<?php

class Piece {

    private $posX;
    private $posY;
    private $pId;
    private $moveX;
    private $moveY;

    public function __construct($x,$y,$direction,$id) {
        $this->moveY = array(-1,1);
        $this->moveX = array($direction);
        $this->posX = $x;
        $this->posY = $y;
        $this->pId = $id;
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
        $this->moveX = array(-1,1);
    }
}