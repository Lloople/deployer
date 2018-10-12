<?php

namespace Deployer\Services\Bitbucket;

use Deployer\Services\Commit;

class BitbucketCommit extends Commit
{

    public function __construct($rawData)
    {
        parent::__construct($rawData);

        $this->setAuthor($this->extractAuthorFromChange());
        $this->setType($rawData->new->type);
        $this->setMessage($rawData->new->target->message);
        $this->setBranch($rawData->new->name);
    }

    public function extractAuthorFromChange()
    {
        $author = $this->rawData->new->target->author;

        return $author->user->display_name ?? $author->raw;
    }
}