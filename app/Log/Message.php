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

    public function getTypeShort(): string
    {
        return substr($this->getType(), 0, 3);
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

    public function log()
    {
        file_put_contents('deployer.log', $this->getDate(). ' - ' . $this->formatted(), FILE_APPEND);
    }

    public function formatted()
    {
        return strtoupper($this->getTypeShort()) . ': ' . $this->getMessage() . PHP_EOL;
    }

    private function getDate()
    {
        return date('Y-m-d H:i:s');
    }

}