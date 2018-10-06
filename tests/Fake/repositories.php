<?php

return [
    'token' => [
        'repository' => 'https://github.com/foo/bar',
        'deployer'   => \Deployer\Services\Bitbucket\BitbucketService::class,
        'branches'   => [
            'develop' => [
                'path'     => 'foobar.com/develop',
                'commands' => [
                    'git pull origin %branch%',
                    'COMPOSER_HOME="%branchDir%" composer install',
                    'php artisan migrate',
                ],
            ],
        ]
    ],
];