<?php

namespace Deployer\Servers\Bitbucket;


use Deployer\Servers\Change;
use Deployer\Servers\Interfaces\ChangeInterface;

/**
 * Class BitbucketChange
 *
 * @package Deployer\Servers\Bitbucket
 */
class BitbucketChange extends Change implements ChangeInterface
{

    public function setRawData(\stdClass $rawData)
    {
        $this->rawData = $rawData;
    }
    
    public function isBranch() { return $this->getType() == 'branch'; }

}