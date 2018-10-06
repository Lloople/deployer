<?php

require __DIR__ . '/vendor/autoload.php';

$serviceProvider = new \Deployer\Providers\ServiceProvider();

$serviceProvider->load();

$request = new \Deployer\Request();

$service = (new \Deployer\Factories\ServiceFactory())->createFromRequest($request);

$deployer = new Deployer\Deployer();

$deployer->deploy($service);