<?php

namespace Deployer\Exceptions;

use Deployer\Services\Branch;

class BranchPathNotFoundException extends \Exception
{
    public function __construct(Branch $branch)
    {
        parent::__construct("{$branch->getName()} path does not exist.");
    }
}