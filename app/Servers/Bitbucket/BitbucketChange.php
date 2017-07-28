<?php

namespace Deployer\Servers\Bitbucket;

use Deployer\Servers\Change;
use Deployer\Servers\Interfaces\ChangeInterface;


class BitbucketChange extends Change implements ChangeInterface
{

    public function __construct($rawData)
    {
        parent::__construct($rawData);

        $this->setAuthor($this->extractAuthorFromChange())
            ->setType($rawData->new->type)
            ->setMessage($rawData->new->target->message)
            ->setBranch($rawData->new->name);

        return $this;
    }

    public function isBranch()
    {
        return $this->getType() == 'branch';
    }

    public function extractAuthorFromChange()
    {

        $author = $this->rawData->change->new->target->author;

        return $author->user->display_name ?? $author->raw;
    }

}