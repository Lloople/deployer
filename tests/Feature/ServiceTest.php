<?php

namespace Tests\Feature;

use Deployer\Exceptions\InvalidTokenException;
use Deployer\Request;
use Deployer\Services\Service;
use Tests\Fake\FakeService;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    /** @test */
    public function not_authorized_token_throws_exception()
    {
        $this->expectException(InvalidTokenException::class);

        $_SERVER['REQUEST_URI'] = 'invalid-token';

        $service = Service::getFromRequest(new Request());
    }

    /** @test */
    public function can_authorize_a_token()
    {
        $_SERVER['REQUEST_URI'] = 'valid-token';

        config(['repositories.valid-token' => [
            'repository' => 'testing-repository',
            'service' => FakeService::class
        ]]);

        $fakeService = Service::getFromRequest(new Request());

        $this->assertEquals('testing-repository', $fakeService->getRepository());
    }
}