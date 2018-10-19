<?php

namespace Tests\Fake;

use Deployer\Request;

class FakeBitbucketRequest extends Request
{

    private $commits = [];

    public function getPayload()
    {
        return json_decode(json_encode([
            'repository' => [
                'name' => 'testing-repository',
            ],
            'push' => [
                'changes' => $this->commits
            ]
        ]));
    }

    public function withCommits()
    {
        $this->commits = [
            [
                'new' => [
                    'type' => 'branch',
                    'name' => 'demo_branch',
                    'target' => [
                        'author' => [
                            'user' => [
                                'display_name' => 'Test User',
                            ],
                        ],
                        'message' => 'Lorem Ipsum',
                    ],
                ],
            ],
        ];

        return $this;
    }
}