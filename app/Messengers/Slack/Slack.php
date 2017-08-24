<?php


namespace Deployer\Messengers;


use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;

class Slack
{

    private $client;

    private $message;
    private $username;
    private $icon;
    private $channel;

    public function __construct(string $message, array $options = [])
    {
        $this->message = $message;
        $this->client = $this->getClient($options);

        $this->username = $options['username'] ?? config('slack.default.username');
        $this->icon = $options['icon'] ?? config('slack.default.icon');
        $this->channel = $options['channel'] ?? config('slack.default.channel');

    }

    /**
     * @param string $message
     * @return Slack
     */
    public function message(string $message): Slack
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param mixed $username
     * @return Slack
     */
    public function as($username): Slack
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param mixed $icon
     * @return Slack
     */
    public function icon($icon): Slack
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param mixed $channel
     * @return Slack
     */
    public function channel($channel): Slack
    {
        $this->channel = $channel;

        return $this;
    }

    public function send(): RequestInterface
    {
        return $this->client->post('/services/hooks/incoming-webhook', [
            'body' => $this->getParams()
        ]);
    }


    private function getParams(): string
    {
        return json_encode([
            'channel' => $this->channel,
            'text' => $this->message,
            'username' => $this->username,
            'icon_emoji' => $this->icon
        ]);
    }


    private function getClient(array $options): Client
    {
        return new Client([
            'base_url' => $options['base_url'] ?? config('slack.base_url'),
            'defaults' => [
                'query' => [
                    'token' => $options['token'] ?? config('slack.token')
                ],
                'exceptions' => $options['exceptions'] ?? config('slack.exceptions')
            ]
        ]);

    }

}