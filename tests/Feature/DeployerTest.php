<?php

namespace Tests\Feature;

use Deployer\Deployer;
use PHPUnit\Framework\TestCase;
use Tests\Fake\FakeServer;

class DeployerTest extends TestCase
{

    /** @test */
    public function create_app_without_uri_throws_an_exception()
    {
        $this->removeRequestUri();

        $this->expectExceptionMessage('Server Request URI was not found.');

        $app = new Deployer();
    }

    /** @test */
    public function create_app_with_uri()
    {
        $this->mockRequestUri();

        $app = new Deployer();

        $this->assertInstanceOf(Deployer::class, $app);
    }

    /** @test */
    public function token_was_initialized()
    {
        $this->mockRequestUri();

        $app = new Deployer();

        $this->assertEquals('token', $app->getToken());
    }

    /** @test */
    public function not_authorized_token_throws_exception()
    {
        $this->expectExceptionMessage('Not authorized');

        $this->expectExceptionCode(403);

        $this->mockRequestUri('repository-token');

        $app = new Deployer();

        $repositoryConfiguration = $app->getAuthorization();
    }

    /** @test */
    public function can_authorize_a_token()
    {
        $this->mockRequestUri('repository-token');

        $app = new Deployer();

        config(['repositories.repository-token' => ['repository' => 'testing-repository']]);

        $repositoryConfiguration = $app->getAuthorization();

        $this->assertEquals(['repository' => 'testing-repository'], $repositoryConfiguration);
    }

    /** @test */
    public function can_deploy_fake_server()
    {
        $this->mockRequestUri('fake-token');

        $app = new Deployer();

        $this->setFakeRepositoryConfiguration();

        $repositoryConfiguration = $app->getAuthorization();

        $fakeServer = new FakeServer($repositoryConfiguration);

        $this->assertInstanceOf(Deployer::class, $app->deploy($fakeServer));
    }

    private function setFakeRepositoryConfiguration()
    {
        return config([
            'repositories.fake-token' => [
                'repository' => 'fake-repository',
                'branches' => [
                    'fake-develop' => [
                        'path' => 'fake/path',
                        'commands' => 'cd .'
                    ]
                ]
            ]
        ]);
    }

    private function removeRequestUri()
    {
        unset($_SERVER['REQUEST_URI']);
    }

    private function mockRequestUri($token = 'token')
    {
        $_SERVER['REQUEST_URI'] = $token;
    }
}