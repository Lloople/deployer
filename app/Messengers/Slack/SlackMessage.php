<?php

namespace Deployer\Messengers\Slack;

class SlackMessage
{

    /** @var string */
    protected $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    private function isSuccess(): bool { return strpos($this->message, 'SUC:') !== false; }

    private function isError(): bool { return strpos($this->message, 'ERR:') !== false; }

    private function isWarning(): bool { return strpos($this->message, 'WAR:') !== false; }

    public function toParams(): array
    {
        return [
            'text' => $this->getIcon() . PHP_EOL . $this->message,
            'icon_emoji' => $this->getAvatar()
        ];
    }

    private function getIcon(): string
    {
        if ($this->isError()) {
            return ':x:';
        }

        if ($this->isWarning()) {
            return ':warning:';
        }

        return ':white_check_mark:';
    }

    private function getAvatar(): string
    {
        if ($this->isError()) {
            return ":scream:";
        }

        if ($this->isWarning()) {
            return ":thinking_face:";
        }

        if ($this->isSuccess()) {
            return ":grin:";
        }

        return ':bot:';
    }
}