<?php

namespace Deployer\Servers;

abstract class Change
{

    public $rawData;
    private $author;
    private $message;
    private $type;
    private $branch;

    public function __construct($rawData)
    {
        $this->rawData = $rawData;
    }

    public function getAuthor(): string { return $this->author; }

    public function setAuthor(string $author)
    {
        $this->author = $author;

        return $this;
    }

    public function getMessage(): string { return $this->message; }

    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    public function getType(): string { return $this->type; }

    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function getBranch(): string { return $this->branch; }

    public function setBranch(string $branch)
    {
        $this->branch = $branch;

        return $this;
    }
}