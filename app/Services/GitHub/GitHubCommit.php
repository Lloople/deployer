<?php

namespace Deployer\Services\GitHub;

use Deployer\Services\Commit;

class GitHubCommit extends Commit
{

    public function __construct($commit, $branch)
    {
        parent::__construct($commit);

        $this->setAuthor($commit->author->name);
        $this->setType('branch');
        $this->setMessage($commit->message);
        $this->setBranch($branch);
    }
}