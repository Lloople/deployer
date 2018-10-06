<?php


namespace Deployer\Providers;


use Deployer\Exceptions\RepositoriesFileException;

class VerifyInstallationServiceProvider implements ServiceProviderContract
{

    public static function register()
    {
        if (! array_key_exists('repositories', config())) {
            throw new RepositoriesFileException("You must rename `example.repositories.php` into `repositories.php`");
        }
    }
}