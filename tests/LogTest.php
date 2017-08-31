<?php


namespace Tests;



use Deployer\Log\Log;
use Deployer\Log\Message;

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

    private function retrieveLogFirstMessage()
    {
        $messages = $this->log->getMessages();

        return $messages[0] ?? null;
    }

}