<?php

namespace Deployer\Servers\Interfaces;

interface ServerInterface
{

    public function getRepository(): string;

    public function getChanges(): array;

    public function setRepository(string $string);

    public function setChanges(array $array);

    public function beforeDeploymentTasks();

    public function deploymentTasks();

    public function afterDeploymentTasks();
}