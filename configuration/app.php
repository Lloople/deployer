<?php

return [
    'locale'   => 'ca',

    'timezone' => 'Europe/Madrid',

    'debug'    => true,


    'providers' => [
        Deployer\Providers\ConfigurationServiceProvider::class,
        Deployer\Providers\ExceptionHandlerServiceProvider::class,
        Deployer\Providers\VerifyInstallationServiceProvider::class,
    ]
];