<?php


namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidFormatException extends Exception
{


    /**
     * InvalidFormatException constructor.
     */
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        if ($message === null) {
            $message = "Invalid format.";
        }

        parent::__construct($message, $code, $previous);
    }
}
