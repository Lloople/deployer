<?php

namespace Deployer\Providers;

use Deployer\Configuration;

class ConfigurationServiceProvider implements ServiceProvider
{

    public static function register()
    {
        $config = Configuration::instance();

        foreach (glob(base_path('configuration') . '/*.php') as $configFile) {
            $index = pathinfo($configFile, PATHINFO_FILENAME);
            $values = include $configFile;

            $config->set($index, $values);
        }
    }
}