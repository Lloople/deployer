<?php

namespace Deployer;


use Deployer\Providers\DeployerServiceProvider;
use Deployer\Servers\Server;

class Deployer
{

    private $server;

    public function __construct()
    {
        $this->requestToken = str_replace('/', '', $_SERVER['REQUEST_URI']);
        DeployerServiceProvider::load();
    }

    public function getAuthorization()
    {
        foreach(config('repositories') as $repositoryToken => $repositoryInfo) {
            if ($repositoryToken === $this->requestToken) {
                return $repositoryInfo;
            }
        }

        throw new \Exception('Not authorized', 403);

    }

    public function deploy(Server $server)
    {
        $this->server = $server;

        $this->server->beforeDeploymentTasks();
        $this->server->deploymentTasks();
        $this->server->afterDeploymentTasks();
    }

}