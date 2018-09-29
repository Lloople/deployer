<?php

namespace Deployer\Services\Bitbucket;

use Deployer\Services\Service;
use Exception;

class BitbucketService extends Service
{

    /**
     * BitbucketService constructor.
     *
     * @param array $configuration
     *
     * @throws \Exception
     */
    public function __construct(array $configuration)
    {
        parent::__construct($configuration);

        $payload = $this->getPayload();

        if ($payload === null) {
            throw new Exception('BitBucket Payload not found', 404);
        }

        try {

            $this->setRepository($this->payload->repository->name);
            $this->setChanges($this->payload->push->changes);

        } catch (Exception $e) {
            throw new Exception('Bitbucket Payload bad format', 403);
        }
    }

    private function getPayload()
    {
        return json_decode(file_get_contents('php://input'));
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