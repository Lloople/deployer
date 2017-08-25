<?php

namespace Deployer\Servers;

use Deployer\Log\Log;

abstract class Server
{

    /**
     * @var \Deployer\Log
     */
    public $log;

    private $repository;
    private $changes = [];
    private $deployableChanges = [];
    private $branches = [];
    private $notifications = [];

    public function __construct(array $configuration = [])
    {
        $this->setBranches($configuration['branches'] ?? []);
        $this->setMessengers($configuration['messengers'] ?? []);
        $this->log = Log::instance();
    }

    public function getRepository(): string { return $this->repository; }

    public function getChanges(): array { return $this->changes; }

    public function getDeployableChanges(): array { return $this->deployableChanges; }

    public function getBranches(): array { return $this->branches; }

    public function getMessengers(): array { return $this->messengers; }

    public function setRepository(string $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    public function setChanges(array $changes)
    {
        $this->changes = $changes;

        return $this;
    }

    public function addDeployableChange(Change $change)
    {
        $this->deployableChanges[] = $change;
    }

    public function setBranches(array $branches)
    {
        $this->branches = $branches;

        return $this;
    }

    public function setMessengers(array $messengers)
    {
        $this->messengers = $messengers;

        return $this;
    }

    abstract public function beforeDeploymentTasks();
    abstract public function deploymentTasks();
    abstract public function afterDeploymentTasks();
    abstract protected function deploy(Change $change);
}