<?php

namespace Deployer\Services\Bitbucket;

use Deployer\Services\Change;

class BitbucketChange extends Change
{

    public function __construct($rawData)
    {
        parent::__construct($rawData);

        $this->setAuthor($this->extractAuthorFromChange());
        $this->setType($rawData->new->type);
        $this->setMessage($rawData->new->target->message);
        $this->setBranch($rawData->new->name);

        return $this;
    }

    public function extractAuthorFromChange()
    {
        $author = $this->rawData->new->target->author;

        return $author->user->display_name ?? $author->raw;
    }
}