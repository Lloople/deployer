<?php

namespace Deployer\Providers;


class DeployerServiceProvider
{

    const providers = [
        WhoopsServiceProvider::class,
        ConfigurationServiceProvider::class,
    ];

    public static function load()
    {
        foreach (static::providers as $provider) {
            $provider::register();
        }
    }
}