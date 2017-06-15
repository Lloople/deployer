<?php

namespace Deployer\Providers;


use Dotenv\Dotenv;

class DotEnvServiceProvider
{

    public static function register()
    {
        $dotenv = new Dotenv(base_path());
        $dotenv->load();
    }
}