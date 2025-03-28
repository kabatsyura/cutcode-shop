<?php

namespace Tests\Unit\Services\Telegram;

use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Services\Telegram\TelegramBotApi;
use Tests\TestCase;

class TelegramBotApiTest extends TestCase
{
  #[Test]
  public function sendMessage(): void
  {
    Http::fake([
      TelegramBotApi::HOST . '*' => Http::response(['ok' => true])
    ]);

    $response = TelegramBotApi::sendMessage(
      token: 'someToken',
      chatId: 1,
      textMessage: 'Hello from app'
    );

    $this->assertTrue($response);
  }
}
