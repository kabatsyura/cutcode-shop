<?php

namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itSuccessUserCreated(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'test@ya.ru'
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make('name', 'test@ya.ru', '11112222'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@ya.ru'
        ]);
    }
}
