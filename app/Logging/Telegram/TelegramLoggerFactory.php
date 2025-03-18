<?php

declare(strict_types=1);

namespace App\Logging\Telegram;

use Monolog\Logger;

final class TelegramLoggerFactory
{
    public function __invoke(array $config): Logger
    {
        // NOTE: what logger we call in logging.php
        $logger = new Logger('telegram');
        $logger->pushHandler(new TelegramLoggerHandler($config));

        return $logger;
    }
}
