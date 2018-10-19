<?php

namespace Deployer;

use Deployer\Exceptions\BranchPathNotFoundException;
use Deployer\Factories\MessengerFactory;
use Deployer\Log\Log;
use Deployer\Services\Branch;
use Deployer\Services\Commit;
use Deployer\Services\Service;

class Deployer
{

    const VERSION = '2.1.0';

    /** @var \Deployer\Log\Log  */
    private $log;

    public function __construct()
    {
        $this->log = Log::instance(config('app.debug'));
    }

    public function deploy(Service $service)
    {
        $this->log->info(Messages::getDeployingRepository($service->getRepository()));

        $service->getCommits()->filter(function (Commit $commit) use ($service) {
            if ($commit->isBranch() && $service->shouldDeployCommit($commit)) {
                return true;
            }

            $this->log->info("Ignoring branch {$commit->getBranch()}");

            return false;
        })->map(function (Commit $commit) use ($service) {

            return new Branch($commit->getBranch(), $service->getBranchConfiguration($commit->getBranch()));

        })->unique->getName()->each(function (Branch $branch) {
            $this->deployBranch($branch);
        });

        $this->log->info(Messages::getDeploymentCompleted());

        $service->getMessengers()->each(function ($configuration, $messengerClass) {
            $messenger = (new MessengerFactory())->create($messengerClass, $configuration);

            $messenger->send($this->log->dump());
        });

        $response = new Response($this->log->dump(), 200, ['deployer-version' => self::VERSION]);

        $response->send();
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

            $command = str_replace([':branch', ':path'], [$branch->getName(), $branch->getPath()], $command);

            $this->log->info("Executing {$command}");

            exec("cd {$branch->getPath()} && {$command} 2>&1", $output, $return);

            foreach ($output as $outputMessage) {
                $this->log->info("\t {$outputMessage}");
            }

            if ($return !== 0) {
                $this->log->error("An error {$return} has occurred while trying to execute {$command}.");
                break;
            }
        }

        if ($this->log->hasAny('error')) {
            $this->log->error(Messages::getDeployError($branch->getName()));

            return;
        }

        $this->log->success(Messages::getDeploySuccess($branch->getName()));
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