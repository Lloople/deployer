<?php

namespace Deployer\Servers\Bitbucket;


/**
 * Class BitbucketFactory
 *
 * @package Deployer\Servers\Bitbucket
 */
class BitbucketFactory
{

    public static function newChange($changeRaw)
    {

        $change = new BitbucketChange();
        $change->setRawData($changeRaw);
        $author = $changeRaw->new->target->author;

        $change->setAuthor($author->user->display_name ?? $author->raw);
        $change->setType($changeRaw->new->type);
        $change->setMessage($changeRaw->new->target->message);
        $change->setBranch($changeRaw->new->name);

        return $change;
    }
}