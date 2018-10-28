<?php

namespace Deployer\Services\GitHub;

use Deployer\Request;
use Deployer\Services\Service;
use Exception;

class GitHubService extends Service
{

    public function __construct(array $configuration, Request $request)
    {
        parent::__construct($configuration);

        $this->payload = $request->getPayload();

        if ($this->payload === null) {
            throw new Exception('GitHub Payload not found.', 404);
        }

        try {

            $this->repository = $this->payload->repository->name;

            $this->commits = collect($this->payload->commits)->map(function ($commit) {
                return new GitHubCommit($commit, $this->getBranchName());
            });

        } catch (Exception $e) {
            throw new Exception('GitHub Payload bad format.', 403);
        }
    }

    private function getBranchName()
    {
        return str_replace('refs/heads/', '', $this->payload->ref);
    }

}