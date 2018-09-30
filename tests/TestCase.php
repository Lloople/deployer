<?php

namespace Tests;

use Deployer\Deployer;
use Deployer\Log\Log;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    protected function tearDown()
    {
        Log::destroy();

        parent::tearDown();
    }
}