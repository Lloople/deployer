<?php

namespace Deployer\Providers;

use Deployer\Exceptions\Handler;

class ExceptionHandlerServiceProvider implements ServiceProviderContract
{
    public static function register()
    {
        set_exception_handler([(new Handler()), 'handle']);
    }
}