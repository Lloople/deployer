<?php

namespace Tests\Feature;

use Deployer\Deployer;
use Deployer\Exceptions\InvalidTokenException;
use Deployer\Log\Log;
use Deployer\Providers\DeployerServiceProvider;
use Deployer\Providers\ServiceProvider;
use Deployer\Request;
use Deployer\Services\Service;
use Tests\Fake\FakeService;
use Tests\TestCase;

class DeployerTest extends TestCase
{
    /** @test */
    public function service_provider_can_load_providers()
    {
        $serviceProvider = new DeployerServiceProvider();

        $serviceProvider->load([DummyServiceProvider::class]);

        $this->assertTrue(DummyServiceProvider::$loaded);
    }

    /** @test */
    public function log_instance_can_be_set_to_debug()
    {
        config(['app.debug' => true]);

        $app = new Deployer();

        $this->assertTrue(Log::instance()->inDebug());
    }

    /** @test */
    public function log_instance_can_disable_debug()
    {
        config(['app.debug' => false]);

        $app = new Deployer();

        $this->assertFalse(Log::instance()->inDebug());
    }

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

class DummyServiceProvider implements ServiceProvider
{
    public static $loaded = false;

    public static function register()
    {
        self::$loaded = true;
    }
};