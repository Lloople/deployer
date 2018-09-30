<?php

require __DIR__ . '/vendor/autoload.php';

$serviceProvider = new \Deployer\Providers\DeployerServiceProvider();

$serviceProvider->load();

$request = new \Deployer\Request();

$app = new Deployer\Deployer();

$service = \Deployer\Services\Service::getFromRequest($request);

$app->run($service);