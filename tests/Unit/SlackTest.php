<?php

namespace Tests\Unit;

use Deployer\Messengers\Slack\SlackMessenger;
use GuzzleHttp\Client;
use Tests\TestCase;

class SlackTest extends TestCase
{

    /**
     * @var SlackMessenger
     */
    protected $slack;

    public function setUp()
    {
        parent::setUp();

        $this->slack = new SlackMessenger(['token' => '🐶🐱🐴🐟']);
    }

    /** @test */
    public function can_create_slack_message_instance()
    {
        $this->assertInstanceOf(SlackMessenger::class, $this->slack);
    }

    /** @test */
    public function slack_has_client_with_base_uri()
    {
        $this->assertInstanceOf(Client::class, $this->slack->getClient());
    }

    /** @test */
    public function can_modify_slack_params()
    {
        $this->slack->as('another_user')->channel('#testing');

        $params = $this->slack->getParams();

        $this->assertStringStartsWith('another_user - ' . strtoupper(gethostname()) . ' - ' . date('Y-m-d H:'), $params['username']);

        $this->assertEquals($params['channel'], '#testing');

        $this->assertEquals($params['token'], '🐶🐱🐴🐟');
    }
}