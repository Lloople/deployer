<?php

namespace Deployer\Servers\Bitbucket;

use Deployer\Servers\Change;
use Deployer\Servers\Server;
use Exception;

class BitbucketServer extends Server
{
    private $payload;

    public function __construct(array $configuration)
    {
        parent::__construct($configuration);

        if (is_null($this->payload = $this->getPayload()) || ! isset($this->payload->repository)) {
            throw new Exception('BitBucket Payload not found', 404);
        }

        $this->setRepository($this->payload->repository->name);
        $this->setChanges($this->payload->push->changes);
    }

    private function getPayload()
    {
        return json_decode(file_get_contents('php://input'));
    }

    public function setChanges(array $rawChanges)
    {
        $changes = [];

        foreach ($rawChanges as $rawChange) {
            $changes[] = new BitbucketChange($rawChange);
        }

        return parent::setChanges($changes);
    }

    public function beforeDeploymentTasks()
    {
        $this->log->info('Starting to deploy ' . $this->getRepository());

        foreach ($this->getChanges() as $change) {
            if ($change->isBranch() && array_key_exists($change->getBranch(), $this->getBranches())) {
                $this->addDeployableChange($change);
            } else {
                $this->log->warning(BitbucketMessages::getIngoredChange($change->getType(), $change->getBranch()));
            }
        }
    }

    public function afterDeploymentTasks()
    {
        $this->log->info(BitbucketMessages::getDeploymentCompleted());

        foreach ($this->log->getMessages() as $message) {
            if ($this->log->inDebug()) {
                $message->print();
            }
            foreach($this->getMessengers() as $messenger => $configuration) {
                $messengerClass = 'Deployer\Messengers\\' . ucfirst($messenger) . '\\' . ucfirst($messenger);

                (new $messengerClass($message->getMessage(), $configuration))->send();
            }
        }

    }

    /**
     * Deploy each change.
     */
    public function deploymentTasks()
    {
        foreach ($this->getDeployableChanges() as $change) {
            if ($this->deploy($change) && ! $this->log->hasAny('error')) {
                $this->log->success(BitbucketMessages::getDeploySuccess($change->getBranch()));
            } else {
                $this->log->error(BitbucketMessages::getDeployError($change->getBranch()));
            }
        }
    }

    /**
     * Perform an individual deployment task.
     *
     * @param \Deployer\Servers\Change $change
     *
     * @return bool
     */
    protected function deploy(Change $change)
    {
        $branch = $change->getBranch();
        $branchDir = $this->getBranchDir($branch);

        $this->log->info(BitbucketMessages::getDeployingBranch($branch));
        $cdCommand = 'cd ' . $branchDir;

        foreach ($this->getBranchCommands($branch) as $pos => $command) {
            $output = [];
            $commandExec = str_replace(['%branch%', '%branchDir%'], [$branch, $branchDir], $command);

            $this->log->info("Executing " . $commandExec);
            exec($cdCommand . ' && ' . $commandExec, $output, $return);

            foreach ($output as $outputMessage) {
                $this->log->info($outputMessage);
            }

            if ($return !== 0) {
                $this->log->error('An error ' . $return . ' has occured while trying to execute ' . $commandExec);
                break;
            }
        }

        return true;
    }

    /**
     * Return the path to the given branch.
     *
     * @param string $branch
     * @return mixed
     */
    private function getBranchDir(string $branch)
    {
        return $this->getBranches()[$branch]['path'];
    }

    /**
     * Return an array of commands that must be executed for the given branch.
     *
     * @param string $branch
     * @return mixed
     */
    private function getBranchCommands(string $branch)
    {
        return $this->getBranches()[$branch]['commands'];
    }

}