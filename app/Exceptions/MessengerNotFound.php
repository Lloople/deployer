<?php

namespace Deployer\Exceptions;

use Throwable;

class MessengerNotFound extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $code = 403;
        parent::__construct($message, $code, $previous);
    }

}