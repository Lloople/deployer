<?php

namespace Deployer\Services\Bitbucket;

use Deployer\Request;
use Deployer\Services\Service;
use Exception;

class BitbucketService extends Service
{

    public function __construct(array $configuration, Request $request)
    {
        parent::__construct($configuration);

        $payload = $request->getPayload();

        if ($payload === null) {
            throw new Exception('BitBucket Payload not found.', 404);
        }

        try {

            $this->setRepository($payload->repository->name);
            $this->setCommits($payload->push->changes);

        } catch (Exception $e) {
            throw new Exception('Bitbucket Payload bad format.', 403);
        }
    }

    public function setCommits(array $commits)
    {
        $commits = collect($commits)->map(function ($commit) {
            return $commit->new !== null
                ? new BitbucketCommit($commit)
                : null;
        })->filter()->toArray();

        return parent::setCommits($commits);
    }

}