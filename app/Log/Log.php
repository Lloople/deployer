<?php

namespace Deployer\Log;

final class Log
{

    private $messages = [];

    private $debug = false;

    private function __construct() { }

    /**
     * Create or gets the instance of Log.
     *
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

    public function getMessages(): array { return $this->messages; }

    public function count(): int { return count($this->messages); }

    /**
     * Clean the already logged messages.
     */
    public function clear()
    {
        $this->messages = [];
    }

    /**
     * Create a new message.
     *
     * @param string $type
     * @param string $message
     */
    public function message(string $type, string $message)
    {
        $msg = new Message($type, $message);
        $this->messages[] = $msg;

        if ($this->debug) {
            $msg->print();
        }
    }

    /**
     * Create a new message of type info.
     *
     * @param string $message
     */
    public function info(string $message)
    {
        $this->message('info', $message);
    }

    /**
     * Create a new message of type error.
     *
     * @param string $message
     */
    public function error(string $message)
    {
        $this->message('error', $message);
    }

    /**
     * Create a new message of type warning.
     *
     * @param string $message
     */
    public function warning(string $message)
    {
        $this->message('warning', $message);
    }

    /**
     * Create a new message of type success.
     *
     * @param string $message
     */
    public function success(string $message)
    {
        $this->message('success', $message);
    }

    /**
     * Check if the current log contains any message of the given type.
     *
     * @param string $type
     * @return bool
     */
    public function hasAny(string $type): bool
    {
        foreach ($this->getMessages() as $message) {
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

    /**
     * Retrieve all the messages.
     *
     * @return string
     */
    public function dump()
    {
        return implode('', array_map(function (Message $message) {
            return $message->formatted();
        }, $this->getMessages()));
    }
}