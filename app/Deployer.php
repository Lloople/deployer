<?php

namespace Deployer;

use Deployer\Exceptions\BranchPathNotFoundException;
use Deployer\Factories\MessengerFactory;
use Deployer\Log\Log;
use Deployer\Providers\ServiceProviderContract;
use Deployer\Services\Branch;
use Deployer\Services\Service;

class Deployer
{

    const VERSION = '1.0.0';

    /** @var \Deployer\Log\Log  */
    private $log;

    public function __construct()
    {
        $this->log = Log::instance(config('app.debug'));
    }

    /**
     * @param \Deployer\Services\Service $service
     */
    public function deploy(Service $service)
    {
        $this->log->info(Messages::getDeployingRepository($service->getRepository()));

        $service->getBranchesToDeploy()->each(function (Branch $branch) {
            $this->deployBranch($branch);
        });

        $this->afterDeploymentTasks($service);
    }

    /**
     * Perform an individual deployment task.
     *
     * @param \Deployer\Services\Branch $branch
     *
     * @throws \Deployer\Exceptions\BranchPathNotFoundException
     */
    protected function deployBranch(Branch $branch)
    {
        $this->log->info(Messages::getDeployingBranch($branch->getName()));

        $this->checkBranchPathExists($branch);

        foreach ($branch->getCommands() as $command) {

            $output = [];

            $commandExec = str_replace(['%branch%', '%branchDir%'], [$branch->getName(), $branch->getPath()], $command);

            $this->log->info("Executing " . $commandExec);

            exec("cd {$branch->getPath()} && {$commandExec} 2>&1", $output, $return);

            foreach ($output as $outputMessage) {
                $this->log->info("\t " . $outputMessage);
            }

            if ($return !== 0) {
                $this->log->error("An error {$return} has occurred while trying to execute {$commandExec}.");
                break;
            }
        }

        if ($this->log->hasAny('error')) {
            $this->log->error(Messages::getDeployError($branch->getName()));

            return;
        }

        $this->log->success(Messages::getDeploySuccess($branch->getName()));
    }

    public function afterDeploymentTasks(Service $service)
    {
        $this->log->info(Messages::getDeploymentCompleted());

        $logDump = $this->log->dump();

        if ($this->log->inDebug()) {
            echo $logDump;
        }

        foreach ($service->getMessengers() as $messenger => $configuration) {
            $messenger = (new MessengerFactory())->create($messenger, $logDump, $configuration);
            $response = $messenger->send();
        }
    }

    /**
     * @param $branch
     *
     * @throws \Deployer\Exceptions\BranchPathNotFoundException
     */
    private function checkBranchPathExists($branch)
    {
        $output = shell_exec("cd {$branch->getPath()} 2>&1");

        if ($output !== null) {
            $this->log->error($output);

            throw new BranchPathNotFoundException($branch);
        }
    }
}