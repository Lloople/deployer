<?php

namespace Tests\Unit;

use Deployer\Log\Log;
use Deployer\Log\Message;
use Tests\TestCase;

class LogTest extends TestCase
{

    /**
     * @var Log
     */
    private $log;


    public function setUp()
    {
        parent::setUp();
        $this->log = Log::instance();

    }

    /** @test */
    public function can_generate_log_instance()
    {
        $this->assertInstanceOf(Log::class, $this->log);
    }

    /** @test */
    public function log_messages_can_be_cleared()
    {
        $this->log->success('First message');
        $this->log->error('Second message');

        $this->assertEquals(2, $this->log->count());

        $this->log->clear();

        $this->assertEquals(0, $this->log->count());
    }

    /** @test */
    public function can_create_info_message()
    {
        $this->log->clear();

        $this->log->info('Info message');

        $message = $this->retrieveLogFirstMessage();

        $this->assertNotNull($message);

        $this->assertInstanceOf(Message::class, $message);

        $this->assertEquals('Info message', $message->getMessage());

        $this->assertEquals('info', $message->getType());
    }

    /** @test */
    public function can_create_success_message()
    {
        $this->log->clear();

        $this->log->success('Success message');

        $message = $this->retrieveLogFirstMessage();

        $this->assertNotNull($message);

        $this->assertInstanceOf(Message::class, $message);

        $this->assertEquals('Success message', $message->getMessage());

        $this->assertEquals('success', $message->getType());
    }

    /** @test */
    public function can_create_error_message()
    {
        $this->log->clear();

        $this->log->error('Error message');

        $message = $this->retrieveLogFirstMessage();

        $this->assertNotNull($message);

        $this->assertInstanceOf(Message::class, $message);

        $this->assertEquals('Error message', $message->getMessage());

        $this->assertEquals('error', $message->getType());
    }

    /** @test */
    public function can_create_warning_message()
    {
        $this->log->clear();

        $this->log->warning('Warning message');

        $message = $this->retrieveLogFirstMessage();

        $this->assertNotNull($message);

        $this->assertInstanceOf(Message::class, $message);

        $this->assertEquals('Warning message', $message->getMessage());

        $this->assertEquals('warning', $message->getType());
    }

    private function retrieveLogFirstMessage()
    {
        $messages = $this->log->getMessages();

        return $messages[0] ?? null;
    }

}