<?php

namespace Deployer\Log;

class Message
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $message;

    public function __construct($type, $message)
    {
        $this->setType($type)->setMessage($message);

        return $this;
    }

    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    public function is(string $type): bool
    {
        return $this->getType() === $type;
    }

    public function getType(): string { return $this->type; }

    public function getMessage(): string { return $this->message; }

    public function print()
    {
        echo strtoupper($this->getType()) . ': ' . $this->getMessage() . PHP_EOL;
    }

}