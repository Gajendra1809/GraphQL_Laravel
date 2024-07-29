<?php

namespace App\Exceptions;

use Exception;

class CustomGraphQLException extends Exception
{
    protected $status;

    public function __construct($message = "", $code = 0, $status = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
