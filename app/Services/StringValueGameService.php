<?php

namespace App\Services;

class StringValueGameService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Find best suffix array
     * @param string $s // string
     * @return array // suffix array
     */
    function suffix_array_best(string $s): array {
        $n = strlen($s);
        $k = 1;
        $line = $this->to_int_keys_best(str_split($s));
        while (max($line) < $n - 1) {
            $line = $this->to_int_keys_best(array_map(
                function ($a, $b) use ($n) {
                    return $a * ($n + 1) + $b + 1;
                },
                $line,
                array_merge(array_slice($line, $k), array_fill(0, $k, -1))
            ));
            $k <<= 1;
        }
        return $line;
    }

    /**
     * Get inverse array
     * @param array $l // string
     * @return array // inverse array
     */
    function inverse_array(array $l): array {
        $n = count($l);
        $ans = array_fill(0, $n, 0);
        foreach ($l as $i => $val) {
            $ans[$val] = $i;
        }
        return $ans;
    }

    /**
     * Find best array to int keys
     * @param array $l // array
     * @return array // array to int keys
     */
    function to_int_keys_best(array $l) : array {
        $seen = [];
        $ls = [];
        foreach ($l as $e) {
            if (!in_array($e, $seen)) {
                $ls[] = $e;
                $seen[] = $e;
            }
        }
        sort($ls);
        $index = array_flip($ls);
        return array_map(function($v) use ($index) {
            return $index[$v];
        }, $l);
    }

    /**
     * Find best suffix matrix
     * @param string $s // string
     * @return array // suffix matrix
     */
    function suffix_matrix_best(string $s): array {
        $n = strlen($s);
        $k = 1;
        $line = $this->to_int_keys_best(str_split($s));
        $ans = [$line];
        while (max($line) < $n - 1) {
            $line = $this->to_int_keys_best(array_map(
                function ($a, $b) use ($n) {
                    return $a * ($n + 1) + $b + 1;
                },
                $line,
                array_merge(array_slice($line, $k), array_fill(0, $k, -1))
            ));
            $ans[] = $line;
            $k <<= 1;
        }
        return $ans;
    }

    /**
     * Find best suffix array alternative naive
     * @param string $s // string
     * @return array // suffix array alternative naive
     */
    function suffix_array_alternative_naive(string $s): array {
        $n = strlen($s);
        $suffixes = [];
        for ($i = 0; $i < $n; $i++) {
            $suffixes[] = substr($s, $i);
        }
        array_multisort($suffixes, SORT_STRING, array_keys($suffixes), $sortedKeys);
        return $sortedKeys;
    }

    /**
     * Find conduct code
     * @param array $sm // string matrix
     * @param int $i // current position
     * @param int $j // next position
     * @return int // result
     */
    function lcp(array $sm, int $i, int $j): int {
        $n = count($sm[count($sm) - 1]);
        if ($i == $j) {
            return $n - $i;
        }
        $k = 1 << (count($sm) - 2);
        $ans = 0;
        foreach (array_reverse(array_slice($sm, 0, -1)) as $line) {
            if ($i >= $n || $j >= $n) {
                break;
            }
            if ($line[$i] == $line[$j]) {
                $ans ^= $k;
                $i += $k;
                $j += $k;
            }
            $k >>= 1;
        }
        return $ans;
    }

    /**
     * Find max value of the string
     * @param string $a // string
     * @return array // result
     */
    function maxValue(string $a): int {
        $res = $this->inverse_array($this->suffix_array_best($a));
        $mtx = $this->suffix_matrix_best($a);
        $lcp_res = [];
        for ($n = 0; $n < count($res) - 1; $n++) {
            $lcp_res[] = $this->lcp($mtx, $res[$n], $res[$n + 1]);
        }
        $lcp_res[] = 0;
        $max_score = strlen($a);
        $lcp_res_len = count($lcp_res);
        foreach ($res as $i => $num) {
            if ($lcp_res[$i] <= 1) {
                continue;
            }
            $lcp_res_i = $lcp_res[$i];
            $cnt = 2;
            for ($ii = $i + 1; $ii < $lcp_res_len; $ii++) {
                if ($lcp_res[$ii] >= $lcp_res_i) {
                    $cnt++;
                } else {
                    break;
                }
            }
            for ($ii = $i - 1; $ii >= 0; $ii--) {
                if ($lcp_res[$ii] >= $lcp_res_i) {
                    $cnt++;
                } else {
                    break;
                }
            }
            $max_score = max($cnt * $lcp_res_i, $max_score);
        }
        return $max_score;
    }
}
