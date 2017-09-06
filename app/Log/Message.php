<?php

namespace Deployer\Log;

class Message
{

    private $type;
    private $message;

    public function __construct($type, $message)
    {
        $this->setType($type)
            ->setMessage($message);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    private function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    private function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    public function is(string $type): bool
    {
        return $this->getType() === $type;
    }

    public function print()
    {
        echo $this->formatted();
    }

    public function formatted()
    {
        return strtoupper($this->getType()) . ': ' . $this->getMessage() . PHP_EOL;
    }

}