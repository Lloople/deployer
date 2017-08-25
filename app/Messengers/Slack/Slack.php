<?php


namespace Deployer\Messengers\Slack;


use GuzzleHttp\Client;

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

        $this->username = _get_arr($options, 'username', config('slack.default.username')) . ' - ' . strtoupper(gethostname());
        $this->icon = _get_arr($options, 'icon', config('slack.default.icon'));
        $this->channel = _get_arr($options, 'channel', config('slack.default.channel'));

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

    public function send()
    {
        return $this->client->post('/services/hooks/incoming-webhook', [
            'body' => $this->getParams()
        ]);
    }


    private function getParams()
    {
        return json_encode([
            'channel'     => $this->channel,
            'text'        => '',
            'as_user'     => false,
            'username'    => $this->username,
            'icon_emoji'  => $this->icon,
            'attachments' => [
                [
                    'text'  => $this->message,
                    'color' => $this->getColor(),
                ],
            ],
        ]);
    }


    private function getClient(array $options): Client
    {
        return new Client([
            'base_uri' => _get_arr($options, 'base_uri', config('slack.base_url')),
            'default'  => [
                'query'      => [
                    'token' => _get_arr($options, 'token', config('slack.token')),
                ],
                'exceptions' => _get_arr($options, 'exceptions', config('slack.exceptions')),
            ],
        ]);

    }

    private function getColor()
    {
        if (strpos($this->message, 'ERROR:') !== false) {
            return "#FF0000";
        }

        if (strpos($this->message, 'WARNING:') !== false) {
            return "#F4C542";
        }

        return "00AD2B";
    }

}