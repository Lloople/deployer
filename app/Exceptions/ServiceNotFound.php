<?php

namespace Deployer\Exceptions;

use Throwable;

class ServiceNotFound extends \Exception
{

    public function __construct($class, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Service {$class} was not found. Check your repositories configuration", 403, $previous);
    }

}