<?php

namespace Deployer;

final class Configuration
{

    private $configurations = [];

    private function __construct() { }

    /**
     * @param string|null $index
     *
     * @param string $default
     * @return array|mixed|null
     */
    public function get(string $index = null, $default = '')
    {
        $queryResult = self::instance()->all();

        foreach (explode('.', $index) as $param) {
            if (! isset($queryResult[$param])) {
                return $default;
            }
            $queryResult = $queryResult[$param];
        }

        return $queryResult;

    }

    /**
     * Create or gets the instance of Configuration class.
     *
     * @return \Deployer\Configuration
     */
    public static function instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new Configuration();
        }

        return $instance;
    }

    public function set($key, $value)
    {
        array_set($this->configurations, $key, $value);

        return $this->get($key);

    }


    public function all()
    {
        return $this->configurations;
    }
}