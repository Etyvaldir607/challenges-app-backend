<?php

namespace App\Services;

class ChessGameService
{
    public function sign($a) : int {
        return ($a > 0) ? 1 : (($a < 0) ? -1 : 0);
    }

    public function queensAttack($n, $k, $r_q, $c_q, $obstacles) : int {
        // Write your code here
        $possible = array(
            array(0, 0, 0),
            array(0, 0, 0),
            array(0, 0, 0)
        );
        $possible[1][1] = 0; // not used

        $possible[0][1] = $n - $r_q; // up
        $possible[1][2] = $n - $c_q; // right
        $possible[1][0] = $c_q - 1; // left
        $possible[2][1] = $r_q - 1; // down

        $possible[0][0] = min($possible[0][1], $possible[1][0]); // up left
        $possible[0][2] = min($possible[0][1], $possible[1][2]); // up right
        $possible[2][0] = min($possible[2][1], $possible[1][0]); // down left
        $possible[2][2] = min($possible[2][1], $possible[1][2]); // down right

        $sum = 0;
        for ($i = 0; $i < $k; $i++)
        {
            $diffr = $obstacles[$i][0] - $r_q;
            $diffc = $c_q - $obstacles[$i][1];

            if ($diffr == 0 || $diffc == 0 || abs($diffr) == abs($diffc))
                $possible[1 - $this->sign($diffr)][1 - $this->sign($diffc)] = min($possible[1 - $this->sign($diffr)][1 - $this->sign($diffc)], max(abs($diffr), abs($diffc)) - 1);
        }

        for ($i = 0; $i < 3; $i++)
            for ($j = 0; $j < 3; $j++)
                $sum += $possible[$i][$j];

        return $sum;
    }
}
