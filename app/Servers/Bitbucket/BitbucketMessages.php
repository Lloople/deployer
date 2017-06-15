<?php
/**
 * Created by PhpStorm.
 * User: Lloople
 * Date: 06/04/2017
 * Time: 20:30
 */

namespace Deployer\Servers\Bitbucket;


class BitbucketMessages
{
    
    public static function getIngoredChange($changeType, $changeBranch)
    {
        return 'Change of type ' . $changeType . ' (' . $changeBranch . ') detected and ignored';
    }
    
    public static function getDeploymentCompleted()
    {
        return 'Completed all jobs';
    }
    
    public static function getDeployingBranch($changeBranch)
    {
        return 'Deploying branch ' . $changeBranch;
    }

    public static function getDeploySuccess($changeBranch)
    {
        return 'Branch ' . $changeBranch . ' deployed successfully';
    }

    public static function getDeployError($changeBranch)
    {
        return 'Error deploying branch ' . $changeBranch;
    }
}