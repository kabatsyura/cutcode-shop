<?php

declare(strict_types=1);

namespace Support\Logging\Telegram;

use Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use Services\Telegram\TelegramBotApiContract;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected string $token;
    protected int $chatId;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);

        $this->token = $config['token'];
        $this->chatId = (int) $config['chat_id'];
    }

    protected function write(LogRecord $record): void
    {
        app(TelegramBotApiContract::class)::sendMessage($this->token, $this->chatId, $record->formatted);
    }
}
