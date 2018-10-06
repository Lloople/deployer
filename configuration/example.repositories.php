<?php

return [
    'token' => [
        'repository' => '',
        'service'   => \Deployer\Services\Bitbucket\BitbucketService::class,
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
                'username' => 'Deployer',
                'avatar'   => ':bot:',
            ],
        ],
    ],
];