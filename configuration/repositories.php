<?php

return [
    'token' => [
        'repository' => '',
        'deployer'   => \Deployer\Servers\Bitbucket\BitbucketServer::class,
        'branches'   => [
            'develop' => [
                'path'     => '',
                'commands' => [
                    'git pull origin %branch%',
                    'COMPOSER_HOME="%branchDir%" composer install',
                    'php artisan migrate',
                ],
            ],
        ],
        'messengers' => [
            'slack' => [
                'token'    => '',
                'channel'  => '',
                'username' => '',
                'icon'     => '',
            ],
        ],
    ],
];