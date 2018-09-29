<?php

function dd($var)
{
    dump($var);
    exit;
}

function config($search = null)
{
    $configuration = \Deployer\Configuration::instance();

    if (is_array($search)) {
        reset($search);
        $key = key($search);
        return $configuration->set($key, $search[$key]);
    }

    if (is_null($search)) {
        return $configuration->all();
    }

    return $configuration->get($search);

}

function base_path(string $path = '')
{
    return __DIR__ . '/../' . $path;
}

function app_path(string $path = '')
{
    return __DIR__ . '/' . $path;
}

/**
 * Return the value or the default if it's false, 0, '' or null.
 *
 * @param $value
 * @param $default
 * @return mixed
 */
function _get($value, $default)
{
    return $value ?: $default;
}

/**
 * Return the array property if it exists or the default value  if it's false, 0, '' or null.
 * @param $arr
 * @param $prop
 * @param $default
 * @return mixed
 */
function _get_arr($arr, $prop, $default)
{
    if (! array_key_exists($prop, $arr)) {
        return $default;
    }

    return _get($arr[$prop], $default);
}

function array_set(&$array, $key, $value)
{
    if (is_null($key)) {
        return $array = $value;
    }

    $keys = explode('.', $key);

    while (count($keys) > 1) {
        $key = array_shift($keys);

        // If the key doesn't exist at this depth, we will just create an empty array
        // to hold the next value, allowing us to create the arrays to hold final
        // values at the correct depth. Then we'll keep digging into the array.
        if (! isset($array[$key]) || ! is_array($array[$key])) {
            $array[$key] = [];
        }

        $array = &$array[$key];
    }

    $array[array_shift($keys)] = $value;

    return $array;
}