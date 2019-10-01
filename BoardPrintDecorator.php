<?php

class BoardPrintDecorator
{
    private $board;

    public function __construct($board)
    {
        $this->board = $board;
    }

    public function printBoard() {
        echo "<table>\n";

        if ($this->board->playerTwo->countPieces()<=0) {
            echo '<tr><td><h1>White Wins...</h1></td></tr>';
        }elseif ($this->board->playerOne->countPieces()<=0) {
            echo '<tr><td><h1>Red Wins...</h1></td></tr>';
        }else {
            echo "<tr>\n\t";

            for($i=0; $i<64; $i++) {

                $square = $this->board->squares[$i];

                if($i%8==0 && $i>0) {
                    echo "\n</tr><tr>\n\t";
                }

                if($square->getValid())
                {
                    $x = $square->getPosX();
                    $y = $square->getPosY();

                    if($square->getOccupied()) {
                        $turn = $this->board->getTurn();
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
}