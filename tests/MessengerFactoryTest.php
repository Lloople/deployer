<?php


namespace Tests;


use Deployer\Exceptions\MessengerNotFound;
use Deployer\Factories\MessengerFactory;
use Deployer\Messengers\Slack\Slack;

class MessengerFactoryTest extends TestCase
{

    /**
     * @var MessengerFactory
     */
    protected $factory;

    public function setUp()
    {
        parent::setUp();

        $this->factory = new MessengerFactory();
    }

    /** @test */
    public function can_generate_messenger_class_name()
    {
        $className = $this->factory->getMessengerClass('🕷');

        $this->assertEquals('Deployer\\Messengers\\🕷\\🕷', $className);

        $className = $this->factory->getMessengerClass('spider');

        $this->assertEquals('Deployer\\Messengers\\Spider\\Spider', $className);

    }
    /** @test */
    public function can_create_slack_messenger_from_factory()
    {
        $slack = $this->factory->create('slack', 'This is the message', ['token' => '🐶']);

        $this->assertInstanceOf(Slack::class, $slack);

    }

    /** @test */
    public function cannot_create_spider_messenger_from_factory()
    {
        $this->expectException(MessengerNotFound::class);
        $this->factory->create('🕷', '🕸', ['token' => '🦋']);
    }
}
