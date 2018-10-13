<?php

namespace Tests\Fake;

use Deployer\Request;

class FakeGitHubRequest extends Request
{

    private $commits = [];

    public function getPayload()
    {
        return json_decode(json_encode([
            'ref' => 'refs/head/test_branch',
            'repository' => [
                'name' => 'testing-repository',
            ],
            'commits' => $this->commits
        ]));
    }

    public function withCommits()
    {
        $this->commits = [
            [
                'author' => [
                    'name' => 'Test User',
                ],
                'message' => 'Lorem Ipsum',
            ],
        ];

        return $this;
    }
}