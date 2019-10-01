<?php

class Player {
    private $pieces;
    private $color;
    private $direction;

    public function __construct($color, $direction) {

        $this->color = $color;
        $this->direction = $direction;

        $this->pieces = array();

        if($color=='White'){
            $xCoord = array(0,2,4,6,1,3,5,7,0,2,4,6);
            $yCoord = array(7,7,7,7,6,6,6,6,5,5,5,5);
        }elseif($color=='Red'){
            $xCoord = array(1,3,5,7,0,2,4,6,1,3,5,7);
            $yCoord = array(0,0,0,0,1,1,1,1,2,2,2,2);
        }

        for ($i=0; $i<12; $i++) {
            $y = $xCoord[$i];
            $x = $yCoord[$i];
            $this->pieces[] = new Piece($x,$y,$direction,$i);
        }
    }

    public function &getPieces() {
        return $this->pieces;
    }

    public function &getPiece($id) {
        return $this->pieces[$id];
    }

    public function countPieces() {
        $count = 0;
        foreach($this->pieces as $piece) {
            if(!is_null($piece)) {
                $count++;
            }
        }
        return $count;
    }

    public function &deletePiece($id) {
        $this->pieces[$id] = null;
        return $this->pieces;
    }

    public function move($piece,$x,$y) {
        $pieceObj = $this->pieces[$piece];
        $pieceObj->setPos($x,$y);
        if($this->color=='White' && $x==0) {
            $pieceObj->king();
        }elseif($this->color=='Red' && $x==7) {
            $pieceObj->king();
        }
    }
}