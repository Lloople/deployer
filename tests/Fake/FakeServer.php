<?php


namespace Tests\Fake;


use Deployer\Servers\Change;
use Deployer\Servers\Server;

class FakeServer extends Server
{


    public function beforeDeploymentTasks()
    {
    }

    public function deploymentTasks()
    {
    }

    public function afterDeploymentTasks()
    {
    }

    protected function deploy(Change $change)
    {
    }
}