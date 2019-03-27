<?php

class Board {

    // Member Variables
    private $squares; // Array of 64 Square objects
    private $turn; // White or Red
    private $inactivePlayer; // White or Red
    private $validMove;
    private $playerOne;
    private $playerTwo;

    private $piece;
    private $x;
    private $y;

    // Class Constructor
    public function __construct() {

        for ($i=0; $i<8; $i++) {
            for ($j=0; $j<8; $j++) {
                if(($i%2==0 && $j%2==0) || ($i%2==1 && $j%2==1)){
                    $this->squares[] = new Square($i, $j, false);
                }else{
                    $this->squares[] = new Square($i, $j, true);
                }

            }
        }


        $this->playerOne = new Player('White',-1);
        $this->playerTwo = new Player('Red',1);

        $this->turn = 'White';
        $this->inactivePlayer = 'Red';

        $p1 = $this->playerOne->getPieces();
        $p2 = $this->playerTwo->getPieces();

        foreach($this->squares as $square) {

            $x = $square->getPosX();
            $y = $square->getPosY();

            $square->setOccupied(false);

            foreach($p1 as $p) {
                $pX = $p->getPosX();
                $pY = $p->getPosY();
                if($pX==$x && $pY==$y){
                    $square->setOccupied('White',$p->getId());
                    break;
                }
            }


            foreach($p2 as $p) {
                $pX = $p->getPosX();
                $pY = $p->getPosY();
                if($pX==$x && $pY==$y){
                    $square->setOccupied('Red',$p->getId());
                    break;
                }
            }

        }

    }

    // Class Methods
    public function setBoard() {

        reset($this->squares);
        for ($i=0; $i<8; $i++) {
            for ($j=0; $j<8; $j++) {
                if ( ($i%2==0 && $j%2==0) || ($i%2==1 && $j%2==1) ) {
                    $this->squares[] = new Square($i, $j, false);
                }else {
                    $this->squares[] = new Square($i, $j, true);
                }

            }
        }


        if ($this->getTurn()=='White') {
            $this->playerOne->move($this->piece,$this->x,$this->y);
            $pieces = $this->playerOne->getPieces();
            $otherPieces = $this->playerTwo->getPieces();
            $this->inactivePlayer = 'Red';
        }elseif ($this->getTurn()=='Red') {
            $this->playerTwo->move($this->piece,$this->x,$this->y);
            $pieces = $this->playerTwo->getPieces();
            $otherPieces = $this->playerOne->getPieces();
            $this->inactivePlayer = 'White';
        }

        foreach ($this->squares as $square) {


            $x = $square->getPosX();
            $y = $square->getPosY();

            $square->setOccupied(false);

            foreach ($pieces as $p) {
                if ($p != null) {
                    $pX = $p->getPosX();
                    $pY = $p->getPosY();
                    if ($pX==$x && $pY==$y){
                        $square->setOccupied($this->getTurn(),$p->getId());
                        break;
                    }
                }
            }

            foreach ($otherPieces as $p) {
                if ($p != null) {
                    $pX = $p->getPosX();
                    $pY = $p->getPosY();
                    if ($pX==$x && $pY==$y){
                        $square->setOccupied($this->inactivePlayer,$p->getId());
                        break;
                    }
                }
            }

        }

    } // End method setBoard


    public function moveIsValid() {

        if ($this->getTurn()=='White') {
            $thisPiece = $this->playerOne->getPiece($this->piece);
            //!
            $this->inactivePlayer='Red';
        }elseif ($this->getTurn()=='Red') {
            $thisPiece = $this->playerTwo->getPiece($this->piece);
            //!
            $this->inactivePlayer='White';
        }else{
            exit('Exception occurred!');
        }

        if(is_object($thisPiece)){
            $moveFromX = $thisPiece->getPosX();
            $moveFromY = $thisPiece->getPosY();
            $direction = $thisPiece->getDirection();
        }else{
            exit('thisPiece is not an object!');
        }


        /*
        if($moveFromX+1==$x && $moveFromY+1==$y) {
            return 'move';
        }elseif($moveFromX-1==$x && $moveFromY-1==$y) {
            return 'move';
        }elseif($moveFromX-1==$x && $moveFromY+1==$y) {
            return 'move';
        }elseif($moveFromX+1==$x && $moveFromY-1==$y) {
            return 'move';
        }*/
        //Check if move is valid. Returns true or false
        foreach($direction as $d) {
            if($moveFromX + $d == $this->x && $moveFromY + 1 == $this->y) {
                $this->validMove=true;
                return 'move';
            }elseif($moveFromX + $d == $this->x && $moveFromY - 1 == $this->y) {
                $this->validMove=true;
                return 'move';
            }
        }
        if($moveFromX+2==$this->x && $moveFromY+2==$this->y) {
            foreach($this->squares as $thisSquare) {
                //echo $this->turn.'-'. $this->inactivePlayer.'-' . $thisSquare->getOccupied() . '<br />';
                if($thisSquare->getPosX()==$moveFromX+1 && $thisSquare->getPosY()==$moveFromY+1 && $thisSquare->getOccupied()==$this->inactivePlayer) {
                    if($this->getTurn()=='White') {
                        $this->playerTwo->deletePiece($thisSquare->getPieceId());
                    }elseif($this->getTurn()=='Red') {
                        $this->playerOne->deletePiece($thisSquare->getPieceId());
                    }
                    $this->validMove=true;
                    return 'jump';
                }
            }
            return false;
        }elseif($moveFromX+2==$this->x && $moveFromY-2==$this->y) {
            foreach($this->squares as $thisSquare) {
                //echo $this->turn.'-'. $this->inactivePlayer.'-' . $thisSquare->getOccupied() . '<br />';
                if($thisSquare->getPosX()==$moveFromX+1 && $thisSquare->getPosY()==$moveFromY-1 && $thisSquare->getOccupied()==$this->inactivePlayer) {
                    if($this->getTurn()=='White') {
                        $this->playerTwo->deletePiece($thisSquare->getPieceId());
                    }elseif($this->getTurn()=='Red') {
                        $this->playerOne->deletePiece($thisSquare->getPieceId());
                    }
                    $this->validMove=true;
                    return 'jump';
                }
            }
            return false;
        }elseif($moveFromX-2==$this->x && $moveFromY+2==$this->y) {
            foreach($this->squares as $thisSquare) {
                //echo $this->turn.'-'. $this->inactivePlayer.'-' . $thisSquare->getOccupied() . '<br />';
                if($thisSquare->getPosX()==$moveFromX-1 && $thisSquare->getPosY()==$moveFromY+1 && $thisSquare->getOccupied()==$this->inactivePlayer) {
                    if($this->getTurn()=='White') {
                        $this->playerTwo->deletePiece($thisSquare->getPieceId());
                    }elseif($this->getTurn()=='Red') {
                        $this->playerOne->deletePiece($thisSquare->getPieceId());
                    }
                    $this->validMove=true;
                    return 'jump';
                }
            }
            return false;
        }elseif($moveFromX-2==$this->x && $moveFromY-2==$this->y) {

            foreach($this->squares as $thisSquare) {
                //echo 'Inactive Player: '.$this->inactivePlayer . 'getOccupied'.$thisSquare->getOccupied() . '<br />';
                if($thisSquare->getPosX()==$moveFromX-1 && $thisSquare->getPosY()==$moveFromY-1 && $thisSquare->getOccupied()==$this->inactivePlayer) {
                    if($this->getTurn()=='White') {
                        $this->playerTwo->deletePiece($thisSquare->getPieceId());
                    }elseif($this->getTurn()=='Red') {
                        $this->playerOne->deletePiece($thisSquare->getPieceId());
                    }
                    $this->validMove=true;
                    return 'jump';
                }
            }
            $this->validMove=false;
            return false;
        }else {
            $this->validMove=false;
            return false;
        }
    }


    public function printBoard() {
        echo "<table>\n";

        if ($this->playerTwo->countPieces()<=0) {
            echo '<tr><td><h1>White Wins...</h1></td></tr>';
        }elseif ($this->playerOne->countPieces()<=0) {
            echo '<tr><td><h1>Red Wins...</h1></td></tr>';
        }else {
            echo "<tr>\n\t";
            for($i=0; $i<64; $i++) {

                $square = $this->squares[$i];
                if($i%8==0 && $i>0) {
                    echo "\n</tr><tr>\n\t";
                }

                if($square->getValid()) {


                    $x = $square->getPosX();
                    $y = $square->getPosY();

                    if($square->getOccupied()) {
                        $turn = $this->getTurn();
                        $color = $square->getOccupied();
                        $id = $square->getPieceId();

                        if($color == 'Red' && $turn == 'Red') {
                            echo "<td class=\"red\"><input type=\"checkbox\" name=\"piece\" value=\"$id\" />&nbsp;</td>";
                        }elseif($color == 'White' && $turn == 'White') {
                            echo "<td class=\"white\"><input type=\"checkbox\" name=\"piece\" value=\"$id\" />&nbsp;</td>";
                        }elseif($color == 'Red') {
                            echo "<td class=\"red\">&nbsp;</td>";
                        }elseif($color == 'White') {
                            echo "<td class=\"white\">&nbsp;</td>";
                        }

                    }else {
                        echo "<td><input type=\"checkbox\" name=\"n\" value=\"$x-$y\" />&nbsp;</td>";
                    }

                }else {
                    echo "<td class=\"\">&nbsp;</td>";
                }


            }
            echo "\n</tr>";
        }
        echo "\n</table>";
    } // End method printBoard()

    /*
     * GETTERS & SETTERS
     */
    public function getPlayerOne() {
        return $this->playerOne;
    }
    public function getPlayerTwo() {
        return $this->playerTwo;
    }

    public function setTurn($color) {
        $this->turn = $color;
    }

    public function getTurn() {
        return $this->turn;
    }

    public function setX($num) {
        $this->x = $num;
    }

    public function setY($num) {
        $this->y = $num;
    }

    public function setPiece($id) {
        $this->piece = $id;
    }


} // End class definition


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
        $this->occupied = $color; // White, Red, or false
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


} // End class definition