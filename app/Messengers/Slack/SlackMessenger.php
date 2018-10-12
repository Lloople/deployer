<?php

namespace Deployer\Messengers\Slack;

use GuzzleHttp\Client;

class SlackMessenger
{

    private $client;

    private $username;
    private $channel;
    private $token;

    public function __construct(array $options = [])
    {
        $this->client = $this->setClient($options);

        $this->token = _get_arr($options, 'token', config('slack.token'));

        if ($this->token == '') {
            throw new \Exception('No Slack token provided', 403);
        }

        $this->username = _get_arr($options, 'username', config('slack.default.username'));
        $this->channel = _get_arr($options, 'channel', config('slack.default.channel'));
    }

    /**
     * @param mixed $username
     *
     * @return SlackMessenger
     */
    public function as($username): SlackMessenger
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param mixed $channel
     *
     * @return SlackMessenger
     */
    public function channel($channel): SlackMessenger
    {
        $this->channel = $channel;

        return $this;
    }

    public function send(string $message)
    {
        $slackMessage = new SlackMessage($message);

        return $this->client->post('/api/chat.postMessage', [
            'form_params' => array_merge(
                $this->getParams(),
                $slackMessage->toParams()
            )
        ]);
    }

    public function getParams(string $key = '')
    {
        $params = [
            'token'      => $this->token,
            'channel'    => $this->channel,
            'as_user'    => false,
            'username'   => $this->getUsername(),
        ];

        if ($key !== '' && array_key_exists($key, $params)) {
            return $params[$key];
        }

        return $params;
    }

    private function setClient(array $options): Client
    {
        return new Client([
            'base_uri' => _get_arr($options, 'base_uri', config('slack.base_uri')),
        ]);
    }

    public function getClient(): Client { return $this->client; }

    private function getUsername(): string
    {
        return $this->username.' - '.strtoupper(gethostname()).' - '.date('Y-m-d H:i:s');
    }
}