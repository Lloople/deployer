<?php

namespace Deployer\Services;

use Deployer\Log\Log;
use Tightenco\Collect\Support\Collection;

abstract class Service
{

    /**
     * @var \Deployer\Log
     */
    public $log;

    private $repository;
    private $changes = [];
    private $deployableChanges = [];
    private $branches = [];

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

    public function getChangesToDeploy(): Collection
    {
        return collect($this->getChanges())->filter(function (Change $change) {
            return $change->isBranch() && $this->shouldDeployChange($change);
        });
    }

    public function shouldDeployChange(Change $change)
    {
        return in_array($change->getBranch(), $this->getBranches());
    }

    /**
     * Return the path to the given branch.
     *
     * @param string $branch
     * @return mixed
     */
    public function getBranchDir(string $branch)
    {
        return $this->getBranches()[$branch]['path'];
    }

    /**
     * Return an array of commands that must be executed for the given branch.
     *
     * @param string $branch
     * @return mixed
     */
    public function getBranchCommands(string $branch)
    {
        return $this->getBranches()[$branch]['commands'];
    }
}