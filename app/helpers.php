<?php

function dd($var)
{
    dump($var);
    exit;
}

function config(string $index = null)
{
    $configuration = \Deployer\Configuration::instance();

    if (is_null($index)) {
        return $configuration->all();
    } else {
        return $configuration->get($index);
    }
}

function base_path(string $path = '')
{
    return __DIR__ . '/../' . $path;
}

function app_path(string $path = '')
{
    return __DIR__ . '/' . $path;
}

function _get($value, $default)
{
    return $value ?: $default;
}

function _get_arr($arr, $prop, $default)
{
    if (! array_key_exists($prop, $arr)) {
        return $default;
    }

    return _get($arr[$prop], $default);
}