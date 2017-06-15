<?php

require __DIR__ . '/vendor/autoload.php';

$deployer = new Deployer\Deployer();

$repository = $deployer->getAuthorization();

$server = new $repository['deployer']($repository);

$server->log->setDebug(config('app.debug'));

$deployer->deploy($server);