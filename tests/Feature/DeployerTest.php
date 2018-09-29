<?php

namespace Tests\Feature;

use Deployer\Configuration;
use Deployer\Deployer;
use PHPUnit\Framework\TestCase;
use Tests\Fake\FakeService;

class DeployerTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $config = Configuration::instance();

        $config->set('repositories', include base_path('tests/Fake/repositories.php'));
    }

    /** @test */
    public function create_app_without_uri_throws_an_exception()
    {
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

        $repositoryConfiguration = $app->getRepositoryConfiguration();
    }

    /** @test */
    public function can_authorize_a_token()
    {
        $this->mockRequestUri('repository-token');

        $app = new Deployer();

        config(['repositories.repository-token' => ['repository' => 'testing-repository']]);

        $repositoryConfiguration = $app->getRepositoryConfiguration();

        $this->assertEquals(['repository' => 'testing-repository'], $repositoryConfiguration);
    }

    /** @test */
    public function can_deploy_fake_server()
    {
        $this->mockRequestUri('fake-token');

        $app = new Deployer();

        $this->setFakeRepositoryConfiguration();

        $repositoryConfiguration = $app->getRepositoryConfiguration();

        $fakeServer = new FakeService($repositoryConfiguration);

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

    private function mockRequestUri($token = 'token')
    {
        $_SERVER['REQUEST_URI'] = $token;
    }
}