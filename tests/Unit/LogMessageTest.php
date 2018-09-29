<?php

namespace Tests\Unit;

use Deployer\Log\Message;
use Tests\TestCase;

class LogMessageTest extends TestCase
{

    /** @test */
    public function can_create_new_messages()
    {
        $message = new Message('success', 'Success message!');

        $this->assertInstanceOf(Message::class, $message);
    }

    /** @test */
    public function can_check_the_type_of_the_message()
    {
        $message = new Message('success', 'Success message!');

        $this->assertEquals('success', $message->getType());

        $this->assertTrue($message->is('success'));
    }

    /** @test */
    public function properties_can_be_retrieved()
    {
        $message = new Message('Type', 'Message');

        $this->assertEquals('Type', $message->getType());

        $this->assertEquals('Message', $message->getMessage());
    }

    /** @test */
    public function message_can_be_formatted()
    {
        $message = new Message('success', 'Message format testing');

        $this->assertEquals('SUCCESS: Message format testing' . PHP_EOL, $message->formatted());

        $message = new Message('🐶', '🌭');

        $this->assertEquals('🐶: 🌭' . PHP_EOL, $message->formatted());
    }


}