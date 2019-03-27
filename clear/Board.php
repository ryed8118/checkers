<?php

class Board {
    private $squares;
    private $turn;
    private $inactivePlayer;
    private $validMove;
    private $playerOne;
    private $playerTwo;

    private $piece;
    private $x;
    private $y;

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

            $this->instancePiece($p1, $x, $y, $square, 'White');
            $this->instancePiece($p2, $x, $y, $square, 'Red');
        }
    }

    public function instancePiece($piece, $x, $y, $square, $color)
    {
        foreach($piece as $p) {
            if($p != null)
            {
                $pX = $p->getPosX();
                $pY = $p->getPosY();
                if($pX==$x && $pY==$y){
                    $square->setOccupied($color, $p->getId());
                    break;
                }
            }
        }
    }

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

            $this->instancePiece($pieces, $x, $y, $square, $this->getTurn());
            $this->instancePiece($otherPieces, $x, $y, $square, $this->inactivePlayer);
        }

    }

    public function moveIsValid() {

        if ($this->getTurn()=='White') {
            $thisPiece = $this->playerOne->getPiece($this->piece);
            $this->inactivePlayer='Red';
        }elseif ($this->getTurn()=='Red') {
            $thisPiece = $this->playerTwo->getPiece($this->piece);
            $this->inactivePlayer='White';
        }else{
            exit('Error occurred!');
        }

        if(is_object($thisPiece)){
            $moveFromX = $thisPiece->getPosX();
            $moveFromY = $thisPiece->getPosY();
            $direction = $thisPiece->getDirection();
        }else{
            exit('thisPiece is not an object!');
        }

        foreach($direction as $d) {
            if($moveFromX + $d == $this->x && $moveFromY + 1 == $this->y) {
                $this->validMove=true;
                return 'move';
            }elseif($moveFromX + $d == $this->x && $moveFromY - 1 == $this->y) {
                $this->validMove=true;
                return 'move';
            }
        }

        return $this->checkNearbyPieces($moveFromX, $moveFromY);
    }

    public function checkNearbyPieces($moveFromX, $moveFromY)
    {
        if($moveFromX+2==$this->x && $moveFromY+2==$this->y) {
            foreach($this->squares as $thisSquare) {
                if($thisSquare->getPosX()==$moveFromX+1 && $thisSquare->getPosY()==$moveFromY+1 && $thisSquare->getOccupied()==$this->inactivePlayer) {
                    return $this->capturePiece($thisSquare);
                }
            }
            return false;
        }elseif($moveFromX+2==$this->x && $moveFromY-2==$this->y) {
            foreach($this->squares as $thisSquare) {
                if($thisSquare->getPosX()==$moveFromX+1 && $thisSquare->getPosY()==$moveFromY-1 && $thisSquare->getOccupied()==$this->inactivePlayer) {
                    return $this->capturePiece($thisSquare);
                }
            }
            return false;
        }elseif($moveFromX-2==$this->x && $moveFromY+2==$this->y) {
            foreach($this->squares as $thisSquare) {
                if($thisSquare->getPosX()==$moveFromX-1 && $thisSquare->getPosY()==$moveFromY+1 && $thisSquare->getOccupied()==$this->inactivePlayer) {
                    return $this->capturePiece($thisSquare);
                }
            }
            return false;
        }elseif($moveFromX-2==$this->x && $moveFromY-2==$this->y) {
            foreach($this->squares as $thisSquare) {
                if($thisSquare->getPosX()==$moveFromX-1 && $thisSquare->getPosY()==$moveFromY-1 && $thisSquare->getOccupied()==$this->inactivePlayer) {
                    return $this->capturePiece($thisSquare);
                }
            }
            $this->validMove=false;
            return false;
        }else {
            $this->validMove=false;
            return false;
        }
    }

    public function capturePiece($square)
    {
        if($this->getTurn()=='White') {
            $this->playerTwo->deletePiece($square->getPieceId());
        }elseif($this->getTurn()=='Red') {
            $this->playerOne->deletePiece($square->getPieceId());
        }
        $this->validMove=true;
        return 'jump';
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

                if($square->getValid())
                {
                    $x = $square->getPosX();
                    $y = $square->getPosY();

                    if($square->getOccupied()) {
                        $turn = $this->getTurn();
                        $color = $square->getOccupied();
                        $id = $square->getPieceId();

                        if($color == 'Red' && $turn == 'Red') {
                            echo "<td class=\"red\"><div class='red-piece'><input type=\"checkbox\" name=\"piece\" value=\"$id\" /></div>&nbsp;</td>";
                        }elseif($color == 'White' && $turn == 'White') {
                            echo "<td class=\"white\"><div class='white-piece'><input type=\"checkbox\" name=\"piece\" value=\"$id\" /></div>&nbsp;</td>";
                        }elseif($color == 'Red') {
                            echo "<td class=\"red\"><div class='red-piece'></div>&nbsp;</td>";
                        }elseif($color == 'White') {
                            echo "<td class=\"white\"><div class='white-piece'></div>&nbsp;</td>";
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
    }

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
}