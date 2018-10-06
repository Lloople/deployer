<?php

namespace Tests\Feature;

use Deployer\Exceptions\InvalidTokenException;
use Deployer\Request;
use Tests\TestCase;

class RequestTest extends TestCase
{

    /** @test */
    public function exception_is_thrown_if_request_cannot_get_the_token()
    {
        $this->expectException(InvalidTokenException::class);

        unset($_SERVER['REQUEST_URI']);

        $request = new Request();
    }

    /** @test */
    public function request_can_get_the_token_from_server_variables()
    {
        $_SERVER['REQUEST_URI'] = 'foo-bar';

        $request = new Request();

        $this->assertEquals('foo-bar', $request->getToken());
    }

}