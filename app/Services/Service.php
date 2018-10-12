<?php

namespace Deployer\Services;

use Tightenco\Collect\Support\Collection;

abstract class Service
{
    /** @var string */
    protected $repository;

    /** @var Collection */
    protected $commits;

    protected $messengers = [];
    protected $branches = [];

    public function __construct(array $configuration = [])
    {
        $this->branches = $configuration['branches'] ?? [];
        $this->messengers = $configuration['messengers'] ?? [];
        $this->repository = $configuration['repository'];
    }

    public function getRepository(): string { return $this->repository; }

    public function getCommits(): Collection { return $this->commits; }

    public function getBranchConfiguration($branch): array { return $this->branches[$branch]; }

    public function getMessengers(): Collection
    {
        return collect($this->messengers);
    }

    public function shouldDeployCommit(Commit $commit): bool
    {
        return array_key_exists($commit->getBranch(), $this->branches);
    }
}