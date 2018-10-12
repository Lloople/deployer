<?php

namespace Deployer\Exceptions;

class InvalidTokenException extends \Exception
{

    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Server Request URI was not found.', 403, $previous);
    }
}