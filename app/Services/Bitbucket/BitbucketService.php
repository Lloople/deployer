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
            $this->setChanges($payload->push->changes);

        } catch (Exception $e) {
            throw new Exception('Bitbucket Payload bad format.', 403);
        }
    }

    public function setChanges(array $rawChanges)
    {
        $changes = [];

        foreach ($rawChanges as $rawChange) {
            if ($rawChange->new !== null) {
                $changes[] = new BitbucketChange($rawChange);
            }
        }

        return parent::setChanges($changes);
    }

}