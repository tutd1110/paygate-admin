<?php

namespace App\Mylib;

class HocmaiUser
{
    static function checkEmail($email)
    {
        if (strpos($email, '@hocmai.vn')) {
            return true;
        } else {
            return false;
        }
    }
}
