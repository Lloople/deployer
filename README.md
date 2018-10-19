<p align="center"><img width="500" src="https://raw.githubusercontent.com/Lloople/deployer/master/logo.png"></p>

Deploy your projects with this easy & simple tool. Install it on your server and configure the repositories
and the commands to be executed per branch.

## Requirements
- PHP 7.1+
- Web server Apache or Nginx
- SSH Key authorization for private repositories 

## Currently supported services
- Bitbucket
- Github

## Configuration

Copy the `configuration/example.repositories.php`, rename it to `repositories.php` and configure it to your
repository needs. For example my personal blog `davidllop.com`: 

```php
<?php

return [
    'secret-token' => [
        'repository' => 'davidllop.com',
        'service'   => \Deployer\Services\Github\GitHubService::class,
        'branches'   => [
            'master' => [
                'path'     => '/var/www/davidllop.com/master', // path where the master branch is deployed
                'commands' => [
                    'git pull origin :branch',
                    'COMPOSER_HOME=":path" composer install',
                    'php artisan cache:clear',
                ],
            ],
        ],
        'messengers' => [
            'slack' => [
                'token'    => 'slack-secret-token',
                'channel'  => 'deployments',
                'username' => 'Deployer@davidllop.com',
                'avatar'   => ':bot:',
            ],
        ],
    ],
];
```

You need to add a Webhook to your GitHub or Bitbucket repository, following the previous example, the url for the
repository davidllop.com would be `https://deployer.davidllop.com/secret-token`.

If you work with private repositories, you'll need to allow SSH access to perform deployment tasks such as `git pull`.

## Security Vulnerabilities

If you discover a security vulnerability within Deployer, please send an e-mail to David Llop at d.lloople@icloud.com. All security vulnerabilities will be promptly addressed.

## License

Deployer is free software distributed under the terms of the MIT license.