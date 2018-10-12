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

    protected $repository;
    protected $commits = [];
    protected $messengers = [];
    protected $branches = [];

    public function __construct(array $configuration = [])
    {
        $this->branches = $configuration['branches'] ?? [];
        $this->messengers = $configuration['messengers'] ?? [];
        $this->repository = $configuration['repository'];

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

    public function setCommits(array $commits)
    {
        $this->commits = $commits;

        return $this;
    }

    public function getBranchesToDeploy(): Collection
    {
        return collect($this->commits)->filter(function (Commit $commit) {
            return $commit->isBranch() && $this->shouldDeployCommit($commit);
        })->map(function (Commit $commit) {

            return new Branch($commit->getBranch(), $this->branches[$commit->getBranch()]);
        })->unique->getName();
    }

    public function shouldDeployCommit(Commit $commit)
    {
        return array_key_exists($commit->getBranch(), $this->branches);
    }
}