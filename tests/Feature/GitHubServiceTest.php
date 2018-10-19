<?php

namespace Tests\Feature;

use Deployer\Exceptions\InvalidTokenException;
use Deployer\Factories\ServiceFactory;
use Deployer\Request;
use Deployer\Services\Bitbucket\BitbucketCommit;
use Deployer\Services\Bitbucket\BitbucketService;
use Deployer\Services\GitHub\GitHubCommit;
use Deployer\Services\GitHub\GitHubService;
use Tests\Fake\FakeBitbucketRequest;
use Tests\Fake\FakeGitHubRequest;
use Tests\Fake\FakeService;
use Tests\TestCase;
use Tightenco\Collect\Support\Collection;

class GitHubServiceTest extends TestCase
{
    /** @test */
    public function can_create_a_new_service_from_payload()
    {
        $_SERVER['REQUEST_URI'] = 'valid-token';

        config(['repositories.valid-token' => [
            'repository' => 'testing-repository',
            'service' => GitHubService::class
        ]]);

        $service = (new ServiceFactory())->createFromRequest(new FakeGitHubRequest());

        $this->assertEquals('testing-repository', $service->getRepository());
        $this->assertInstanceOf(Collection::class, $service->getCommits());
    }

    /** @test */
    public function can_create_commits()
    {
        $_SERVER['REQUEST_URI'] = 'valid-token';

        config(['repositories.valid-token' => [
            'repository' => 'testing-repository',
            'service' => GitHubService::class
        ]]);

        $service = (new ServiceFactory())->createFromRequest((new FakeGitHubRequest())->withCommits());

        $this->assertEquals('testing-repository', $service->getRepository());
        $this->assertInstanceOf(GitHubCommit::class, $service->getCommits()->first());
    }
}