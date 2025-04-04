<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Telegram;

use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;
use Support\ValueObjects\Price;
use Tests\TestCase;

final class TelegramBotApiTest extends TestCase
{
    #[Test]
    public function itSendMessageSuccessByHttpFake(): void
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['ok' => true])
        ]);

        $result = TelegramBotApi::sendMessage('', 1, 'Testing');

        $this->assertTrue($result);
    }


    #[Test]
    public function itSendMessageSuccessByFakeInstance(): void
    {
        TelegramBotApi::fake()
            ->returnTrue();

        $result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'Testing');

        $this->assertTrue($result);
    }

    #[Test]
    public function itSendMessageFailByFakeInstance(): void
    {
        TelegramBotApi::fake()
            ->returnFalse();

        $result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'Testing');

        $this->assertFalse($result);
    }

}
