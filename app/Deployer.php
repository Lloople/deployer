<?php

namespace Deployer;

use Deployer\Factories\MessengerFactory;
use Deployer\Log\Log;
use Deployer\Providers\DeployerServiceProvider;
use Deployer\Services\Service;

class Deployer
{

    const VERSION = '1.0.0';

    private $token;

    /** @var Service */
    private $service;

    /** @var \Deployer\Log  */
    private $log;

    /**
     * Deployer constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->initializeToken();

        DeployerServiceProvider::load();

        $this->log = Log::instance(config('app.debug'));
    }

    public function getToken() { return $this->token; }

    /**
     * @throws \Exception
     */
    public function initializeToken()
    {
        if (! isset($_SERVER['REQUEST_URI'])) {
            throw new \Exception('Server Request URI was not found.');
        }

        $this->token = str_replace('/', '', $_SERVER['REQUEST_URI']);
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $this->service = $this->getService();

        $this->log->info(Messages::getDeployingService($this->getService()->getRepository()));

        $this->service->getBranchesToDeploy()->each(function (string $branch) {
            $this->deploy($branch);
        });

        $this->afterDeploymentTasks();
    }

    /**
     * @return Service
     * @throws \Exception
     */
    private function getService()
    {
        $configuration = $this->getRepositoryConfiguration();

        return new $configuration['service']($configuration);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getRepositoryConfiguration()
    {
        $configuration = collect(config('repositories'))->get($this->getToken());

        if (! $configuration) {
            throw new \Exception('Not authorized', 403);
        }

        return $configuration;
    }


    public function afterDeploymentTasks()
    {
        $this->log->info(Messages::getDeploymentCompleted());

        $logDump = $this->log->dump();

        if ($this->log->inDebug()) {
            echo $logDump;
        }

        // todo: Falta re-fer aquesta part
        foreach ($this->getMessengers() as $messenger => $configuration) {
            $messenger = (new MessengerFactory())->create($messenger, $logDump, $configuration);
            $response = $messenger->send();
        }
    }

    /**
     * Perform an individual deployment task.
     *
     * @param string $branch
     */
    protected function deploy(string $branch)
    {
        $this->log->info(Messages::getDeployingBranch($branch));

        foreach ($this->service->getBranchCommands($branch) as $command) {
            $output = [];

            $commandExec = str_replace(['%branch%', '%branchDir%'], [$branch, $this->service->getBranchDir($branch)], $command);

            $this->log->info("Executing " . $commandExec);

            exec("cd {$this->service->getBranchDir($branch)} && {$commandExec}", $output, $return);

            foreach ($output as $outputMessage) {
                $this->log->info($outputMessage);
            }

            if ($return !== 0) {
                $this->log->error("An error {$return} has occurred while trying to execute {$commandExec}");
                break;
            }
        }

        if ($this->log->hasAny('error')) {
            $this->log->error(Messages::getDeployError($branch));

            return;
        }

        $this->log->success(Messages::getDeploySuccess($branch));
    }
}