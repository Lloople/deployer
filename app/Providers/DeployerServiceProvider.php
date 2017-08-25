<?php

namespace Deployer\Providers;


class DeployerServiceProvider
{

    const providers = [
        ConfigurationServiceProvider::class,
        ExceptionHandlerServiceProvider::class
    ];

    public static function load()
    {
        foreach (static::providers as $provider) {
            $provider::register();
        }
    }
}