<?php

namespace Deployer\Factories;

use Deployer\Exceptions\MessengerNotFound;

class MessengerFactory
{
    public function create($class, $message, $configuration)
    {
        $messengerClass = $this->getMessengerClass($class);

        if (! class_exists($messengerClass)) {
            throw new MessengerNotFound();
        }

        return new $messengerClass($message, $configuration);
    }

    public function getMessengerClass($class)
    {
        return 'Deployer\Messengers\\' . ucfirst($class) . '\\' . ucfirst($class);
    }

}