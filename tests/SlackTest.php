<?php

namespace Tests;

use Deployer\Messengers\Slack\Slack;
use GuzzleHttp\Client;

class SlackTest extends TestCase
{

    /**
     * @var Slack
     */
    protected $slack;

    public function setUp()
    {
        parent::setUp();

        $this->slack = new Slack('This is the message', ['token' => '🐶🐱🐴🐟']);
    }
    /** @test */
    public function can_create_slack_message_instance()
    {
        $this->assertInstanceOf(Slack::class, $this->slack);
    }

    /** @test */
    public function slack_has_client_with_base_uri()
    {
        $this->assertInstanceOf(Client::class, $this->slack->getClient());
    }

    /** @test */
    public function show_icon_state_can_be_switched()
    {
        $this->assertTrue($this->slack->showIcon);

        $this->slack->disableIcon();

        $this->assertFalse($this->slack->showIcon);

        $this->slack->enableIcon();

        $this->assertTrue($this->slack->showIcon);

    }

    /** @test */
    public function can_modify_slack_params()
    {
        $this->slack->disableIcon();
        $this->assertEquals($this->slack->printMessage(), 'This is the message');

        $this->slack->as('another_user')->channel('#testing')->avatar(':fire:')->message('🐵');

        $params = $this->slack->getParams();
        $this->assertEquals($params['username'], 'another_user - '.strtoupper(gethostname()).' - '.date('YmdHis'));
        $this->assertEquals($params['channel'], '#testing');
        $this->assertEquals($params['icon_emoji'], ':bot:');
        $this->assertEquals($params['token'], '🐶🐱🐴🐟');
        $this->assertEquals($params['text'], '🐵');
    }

    /** @test */
    public function default_icons_are_set_properly()
    {
        $this->slack->message('SUCCESS: The icon should be grin');
        $this->assertEquals(':grin:', $this->slack->getParams('icon_emoji'));

        $this->slack->message('WARNING: The icon should be thinking face');
        $this->assertEquals(':thinking_face:', $this->slack->getParams('icon_emoji'));

        $this->slack->message('ERROR: The icon should be scream');
        $this->assertEquals(':scream:', $this->slack->getParams('icon_emoji'));
    }


}