<?php

namespace Deployer;

use Deployer\Exceptions\InvalidTokenException;

class Request
{

    /** @var string */
    private $token;

    /** @var string */
    private $payload;

    public function __construct()
    {
        if (! isset($_SERVER['REQUEST_URI'])) {
            throw new InvalidTokenException();
        }

        $this->token = str_replace('/', '', $_SERVER['REQUEST_URI']);

        $this->payload = json_decode(file_get_contents('php://input'));
    }

    public function getToken():string { return $this->token; }

    public function getPayload() { return $this->payload;}
}