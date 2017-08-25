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
    private $token;

    public $showIcon = true;

    public function __construct(string $message, array $options = [])
    {
        $this->message = $message;
        $this->client = $this->setClient($options);

        $this->token = _get_arr($options, 'token', config('slack.token'));

        if ($this->token == '') {
            throw new \Exception('No Slack token provided', 403);
        }
        $this->username = _get_arr($options, 'username', config('slack.default.username'));
        $this->avatar = _get_arr($options, 'avatar', config('slack.default.avatar'));
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
    public function avatar($icon): Slack
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
        return $this->client->post('/api/chat.postMessage', [
            'form_params' => $this->getParams(),
        ]);
    }


    public function getParams(): array
    {
        return [
            'token'      => $this->token,
            'channel'    => $this->channel,
            'text'       => $this->printMessage(),
            'as_user'    => false,
            'username'   => $this->getUsername(),
            'icon_emoji' => $this->getAvatar(),
        ];
    }


    private function setClient(array $options): Client
    {
        return new Client([
            'base_uri' => _get_arr($options, 'base_uri', config('slack.base_uri')),
        ]);
    }

    public function getClient(): Client { return $this->client; }

    public function disableIcon(): Slack
    {
        $this->showIcon = false;

        return $this;
    }

    public function enableIcon(): Slack
    {
        $this->showIcon = true;

        return $this;
    }

    public function printMessage(): string
    {
        $return = '';

        if ($this->showIcon) {
            $return .= $this->getIcon() . PHP_EOL;
        }

        return $return .= $this->message;
    }

    private function getAvatar(): string
    {
        if ($this->messageError()) {
            return ":facepalm-meme:";
        }

        if ($this->messageWarning()) {
            return ":grumpy:";
        }

        if ($this->messageSuccess()) {
            return ":success-kid:";
        }

        return $this->icon;
    }

    private function getIcon(): string
    {
        if ($this->messageError()) {
            return ':x:';
        }

        if ($this->messageWarning()) {
            return ':warning:';
        }

        return ':white_check_mark:';
    }

    private function getUsername(): string
    {
        return $this->username.' - '.strtoupper(gethostname()).' - '.date('Y-m-d H:i:s');

    }

    private function messageSuccess(): bool { return strpos($this->message, 'SUCCESS:') !== false; }
    private function messageError(): bool { return strpos($this->message, 'ERROR:') !== false; }
    private function messageWarning(): bool { return strpos($this->message, 'WARNING:') !== false; }

}