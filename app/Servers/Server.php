<?php

namespace Deployer\Servers;


use Deployer\Log\Log;

/**
 * Class Server
 *
 * @package Deployer\Servers
 */
abstract class Server
{

    /**
     * @var \Deployer\Log\Log;
     */
    public $log;
    /**
     * @var string
     */
    private $repository;
    /**
     * @var array
     */
    private $changes = [];

    /**
     * @var array
     */
    private $deployableChanges = [];

    /**
     * @var array
     */
    private $branches = [];

    public function __construct()
    {
        $this->log = Log::instance();
    }

    /**
     * @return string
     */
    public function getRepository(): string { return $this->repository; }

    /**
     * @param string $repository
     */
    public function setRepository(string $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getChanges(): array { return $this->changes; }

    /**
     * @param array $changes
     */
    public function setChanges(array $changes)
    {
        $this->changes = $changes;
    }

    /**
     * @param \Deployer\Servers\Change $change
     */
    public function addDeployableChange(Change $change)
    {
        $this->deployableChanges[] = $change;
    }

    /**
     * @return array
     */
    public function getDeployableChanges(): array { return $this->deployableChanges; }

    public function getBranches(): array { return $this->branches; }

    public function setBranches(array $branches)
    {
        $this->branches = $branches;
    }
}