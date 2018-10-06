<?php

require __DIR__ . '/vendor/autoload.php';

$serviceProvider = new \Deployer\Providers\ServiceProvider();

$serviceProvider->load();

$request = new \Deployer\Request();

$service = \Deployer\Services\Service::getFromRequest($request);

$deployer = new Deployer\Deployer();

$deployer->deploy($service);