<?php

namespace Deployer\Services;

use Deployer\Configuration;
use Deployer\Exceptions\InvalidTokenException;
use Deployer\Log\Log;
use Deployer\Request;
use Tightenco\Collect\Support\Collection;

abstract class Service
{

    /**
     * @var \Deployer\Log
     */
    public $log;

    protected $repository;
    protected $changes = [];
    protected $messengers = [];
    protected $branches = [];

    public function __construct(array $configuration = [])
    {
        $this->branches = $configuration['branches'] ?? [];
        $this->messengers = $configuration['messengers'] ?? [];
        $this->repository = $configuration['repository'];

        $this->log = Log::instance();
    }

    public static function getFromRequest(Request $request): Service
    {
        $configuration = Configuration::instance()->get('repositories.'.$request->getToken());

        if (! $configuration) {
            throw new InvalidTokenException();
        }

        return new $configuration['service']($configuration, $request);
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

    public function getBranchesToDeploy(): Collection
    {
        return collect($this->getChanges())->filter(function (Change $change) {
            return $change->isBranch() && $this->shouldDeployChange($change);
        })->map(function (Change $change) {
            return $this->createBranch($change->getBranch());
        });
    }

    private function createBranch(string $branch)
    {
        return new Branch($branch, $this->getBranches()[$branch]);
    }

    public function shouldDeployChange(Change $change)
    {
        return array_key_exists($change->getBranch(), $this->getBranches());
    }
}