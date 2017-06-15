<?php

namespace Deployer\Log;

/**
 * @purpose Classe que actua com a Singleton
 *          No podem fer un new Log(), hem de fer un
 *          Log::instance() per tal de recuperar la instància que
 *          ja teniem d'aquesta classe, així només tenim una a
 *          tota l'aplicació
 *
 * Class Log
 *
 * @package Deployer
 */
final class Log
{

    /**
     * @var array
     */
    private $messages = [];

    private $debug = false;

    private function __construct() { }

    /**
     * @purpose Create or gets the instance of Log
     * @return \Deployer\Log
     */
    public static function instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new Log();
        }

        return $instance;
    }

    public function message(string $type, string $message)
    {
        $msg = new Message($type, $message);
        $this->messages[] = $msg;

        if ($this->debug) {
            $msg->print();
        }
    }

    public function info(string $message)
    {
       $this->message('info', $message);
    }

    public function error(string $message)
    {
        $this->message('error', $message);
    }

    public function warning(string $message)
    {
        $this->message('warning', $message);
    }

    public function success(string $message)
    {
        $this->message('success', $message);
    }

    public function getMessages(): array { return $this->messages; }

    public function hasAny(string $type): bool
    {
        foreach($this->getMessages() as $message) {
            if ($message->is($type)) {
                return true;
            }
        }

        return false;
    }

    public function setDebug(bool $state)
    {
        $this->debug = $state;
    }

    public function inDebug(): bool
    {
        return $this->debug;
    }
}