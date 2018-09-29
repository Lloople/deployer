<?php

namespace Deployer\Providers;


class DeployerServiceProvider
{

    public static function load(array $providers = [])
    {
        if (empty($providers)) {
            $providers = self::getAppProviders();
        }

        foreach ($providers as $provider) {
            $provider::register();
        }
    }

    private static function getAppProviders()
    {
        $appConfiguration = include base_path('configuration') . '/app.php';

        return $appConfiguration['providers'];
    }
}