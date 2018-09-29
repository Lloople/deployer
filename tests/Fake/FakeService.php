<?php

namespace Tests\Fake;

use Deployer\Services\Change;
use Deployer\Services\Service;

class FakeService extends Service
{

    public function beforeDeploymentTasks() {}

    public function deploymentTasks() {}

    public function afterDeploymentTasks() {}

    protected function deploy(Change $change) {}
}