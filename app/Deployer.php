<?php

namespace Deployer;

use Deployer\Providers\DeployerServiceProvider;
use Deployer\Servers\Server;

class Deployer
{

    const VERSION = '1.0.0';

    private $server;

    private $token;
    
    public function __construct()
    {

        $this->initializeToken();

        DeployerServiceProvider::load();
    }

    public function initializeToken()
    {
        if (! isset($_SERVER['REQUEST_URI'])) {

            throw new \Exception('Server Request URI was not found.');
        }

        $this->token = str_replace('/', '', $_SERVER['REQUEST_URI']);

    }

    public function getAuthorization()
    {
        foreach (config('repositories') as $repositoryToken => $repositoryInfo) {
            if ($repositoryToken === $this->getToken()) {
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

        return $this;
    }

    public function getToken() { return $this->token; }
}