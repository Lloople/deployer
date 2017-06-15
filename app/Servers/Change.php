<?php

namespace Deployer\Servers;

/**
 * Class Change
 *
 * @package Deployer\Servers
 */
abstract class Change
{

    public $rawData;
    private $author;
    private $message;
    private $type;
    private $branch;

    public function getAuthor(): string { return $this->author; }

    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    public function getMessage(): string { return $this->message; }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getType(): string { return $this->type; }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getBranch(): string { return $this->branch; }

    public function setBranch(string $branch)
    {
        $this->branch = $branch;
    }
}