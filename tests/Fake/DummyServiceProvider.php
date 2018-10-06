<?php


namespace Tests\Fake;

use Deployer\Providers\ServiceProviderContract;

class DummyServiceProvider implements ServiceProviderContract
{
    public static $loaded = false;

    public static function register()
    {
        self::$loaded = true;
    }
};