<?php

namespace Tests;

use Deployer\Deployer;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    /**
     * @var Deployer
     */
    protected $app;

    protected function setUp()
    {
        $this->app = $this->createApplication();
    }

    protected function tearDown()
    {
        $this->app = null;
    }

    public function createApplication()
    {
        $this->mockupRequestUri();

        return new Deployer();
    }

    public function mockupRequestUri()
    {
        $_SERVER['REQUEST_URI'] = 'token';
    }
}