<?php

namespace Deployer\Servers\Interfaces;


interface ChangeInterface
{

    public function setRawData(\stdClass $rawData);

    public function getAuthor(): string;

    public function getBranch(): string;

    public function getMessage(): string;

    public function getType(): string;

    public function setAuthor(string $author);

    public function setMessage(string $message);

    public function setType(string $type);

    public function setBranch(string $branch);

}