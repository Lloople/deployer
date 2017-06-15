<?php

namespace Deployer\Providers;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsServiceProvider
{

    public static function register()
    {
        $run = new Run;
        $handler = new PrettyPageHandler;

        $handler->setPageTitle("Whoops! There was a problem.");

        $run->pushHandler($handler)->register();

    }
}