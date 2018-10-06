<?php

namespace Deployer\Factories;

use Deployer\Configuration;
use Deployer\Exceptions\InvalidTokenException;
use Deployer\Exceptions\ServiceNotFound;
use Deployer\Request;
use Deployer\Services\Service;

class ServiceFactory
{
    public function createFromRequest(Request $request): Service
    {

        $configuration = Configuration::instance()->get('repositories.'.$request->getToken());

        if (! $configuration) {
            throw new InvalidTokenException();
        }

        $serviceClass = $this->getServiceClass($configuration['service']);

        if (! class_exists($serviceClass)) {
            throw new ServiceNotFound();
        }

        return new $serviceClass($configuration, $request);
    }

    public function getServiceClass($class)
    {
        if (class_exists($class)) {
            return $class;
        }

        return 'Deployer\Services\\' . ucfirst($class) . '\\' . ucfirst($class).'Service';
    }

}