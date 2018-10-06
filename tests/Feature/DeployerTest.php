<?php

namespace Tests\Feature;

use Deployer\Deployer;
use Deployer\Log\Log;
use Tests\TestCase;

class DeployerTest extends TestCase
{
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
}