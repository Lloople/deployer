<?php

namespace Deployer\Services;

use Deployer\Exceptions\BranchPathNotFoundException;

class Branch
{

    private $name;
    private $path;
    private $commands;

    /**
     * Branch constructor.
     *
     * @param string $name
     * @param array $branch
     *
     * @throws \Deployer\Exceptions\BranchPathNotFoundException
     */
    public function __construct(string $name, array $branch)
    {
        $this->name = $name;
        $this->path = $branch['path'];
        $this->commands = collect($branch['commands']);

        if (! $this->path) {
            throw new BranchPathNotFoundException($this);
        }
    }

    public function getName(): string { return $this->name; }

    public function getPath(): string { return $this->path; }

    public function getCommands() { return $this->commands; }

}