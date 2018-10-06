<?php

namespace Deployer\Providers;

class ServiceProvider
{

    public function load(array $providers = [])
    {
        if (empty($providers)) {
            $providers = $this->getAppProviders();
        }

        foreach ($providers as $provider) {
            $provider::register();
        }
    }

    private function getAppProviders()
    {
        $appConfiguration = include base_path('configuration') . '/app.php';

        return $appConfiguration['providers'];
    }
}