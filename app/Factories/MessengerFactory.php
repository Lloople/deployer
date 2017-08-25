<?php


namespace Deployer\Factories;


class MessengerFactory
{
    public function create($class, $message, $configuration)
    {
        $messengerClass = $this->getMessengerClass($class);
        return (new $messengerClass($message, $configuration));
    }

    public function getMessengerClass($class)
    {
        return 'Deployer\Messengers\\' . ucfirst($class) . '\\' . ucfirst($class);
    }

}