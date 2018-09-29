<?php

namespace Deployer;

class Messages
{
    
    public static function getIgnoredChange(string $changeType, string $changeBranch): string
    {
        return "Change of type {$changeType} ({$changeBranch}) detected and ignored";
    }
    
    public static function getDeploymentCompleted(): string
    {
        return "Completed all jobs";
    }
    
    public static function getDeployingBranch(string $changeBranch): string
    {
        return "Deploying branch {$changeBranch}";
    }

    public static function getDeploySuccess(string $changeBranch): string
    {
        return "Branch {$changeBranch} deployed successfully";
    }

    public static function getDeployError(string $changeBranch): string
    {
        return "Error deploying branch {$changeBranch}";
    }

    public static function getDeployingService(string $service): string
    {
        return "Deploying repository {$service}";
    }
}