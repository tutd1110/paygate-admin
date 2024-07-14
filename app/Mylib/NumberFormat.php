<?php

namespace App\Mylib;

class NumberFormat
{
    static function currency($number, $decimal = 0)
    {
        return number_format($number, $decimal, ',', '.');
    }
}
