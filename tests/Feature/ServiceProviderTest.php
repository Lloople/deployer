<?php

namespace Tests\Feature;

use Deployer\Providers\ServiceProvider;
use Tests\Fake\DummyServiceProvider;
use Tests\TestCase;

class ServiceProviderTest extends TestCase
{

    /** @test */
    public function service_provider_can_load_providers()
    {
        $serviceProvider = new ServiceProvider();

        $serviceProvider->load([DummyServiceProvider::class]);

        $this->assertTrue(DummyServiceProvider::$loaded);
    }
}