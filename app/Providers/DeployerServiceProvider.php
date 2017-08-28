<?php

namespace Deployer\Providers;


class DeployerServiceProvider
{

    const providers = [
        ConfigurationServiceProvider::class,
        ExceptionHandlerServiceProvider::class,
        VerifyInstallationServiceProvider::class,
    ];

    public static function load()
    {
        foreach (static::providers as $provider) {
            $provider::register();
        }
    }
}