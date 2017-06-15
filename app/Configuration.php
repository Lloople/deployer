<?php

namespace Deployer;

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
final class Configuration
{

    private $configurations = [];

    private function __construct() { }

    /**
     * @param string|null $index
     *
     * @return array|mixed|null
     */
    public function get(string $index = null)
    {
        $queryResult = self::instance()->all();

        foreach (explode('.', $index) as $param) {
            $queryResult = $queryResult[$param];
        }

        return $queryResult;

    }

    /**
     * @purpose Create or gets the instance of Log
     * @return \Deployer\Log
     */
    public static function instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new Configuration();
        }

        return $instance;
    }

    public function set(string $index, array $values)
    {
        $this->configurations[$index] = $values;
    }

    public function all()
    {
        return $this->configurations;
    }
}