<?php

namespace App\Business\Exception;


use Throwable;

class PaidException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}
