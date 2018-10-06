<?php

namespace Tests\Feature;

use Deployer\Exceptions\InvalidTokenException;
use Deployer\Factories\ServiceFactory;
use Deployer\Request;
use Tests\Fake\FakeBitbucketRequest;
use Tests\Fake\FakeService;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    /** @test */
    public function not_authorized_token_throws_exception()
    {
        $this->expectException(InvalidTokenException::class);

        $_SERVER['REQUEST_URI'] = 'invalid-token';

        $service = (new ServiceFactory())->createFromRequest(new Request());
    }

    /** @test */
    public function can_authorize_a_token_with_full_class_name()
    {
        $_SERVER['REQUEST_URI'] = 'valid-token';

        config(['repositories.valid-token' => [
            'repository' => 'testing-repository',
            'service' => FakeService::class
        ]]);

        $fakeService = (new ServiceFactory())->createFromRequest(new Request());

        $this->assertEquals('testing-repository', $fakeService->getRepository());
    }

    /** @test */
    public function can_authorize_a_token_service_name_as_string()
    {
        $_SERVER['REQUEST_URI'] = 'valid-token';

        config(['repositories.valid-token' => [
            'repository' => 'testing-repository',
            'service' => 'bitbucket'
        ]]);

        $fakeService = (new ServiceFactory())->createFromRequest(new FakeBitbucketRequest());

        $this->assertEquals('testing-repository', $fakeService->getRepository());
    }
}