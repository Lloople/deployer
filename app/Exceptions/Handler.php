<?php


namespace Deployer\Exceptions;


use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class Handler
{

    public function handle($e)
    {
        $method = 'show'.$e->getCode();

        if (method_exists($this, $method)) {
            return $this->$method($e->getMessage());
        }

        return (new Run())->pushHandler(new PrettyPageHandler())->handleException($e);
    }

    public function show404($message)
    {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);

        print $message;
    }

    public function show403($message)
    {
        header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden", true, 403);

        print $message;
    }
}