<?php

namespace Tests\Feature\Auth\DTOs;

use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itInstanceCreated(): void
    {
        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name' => 'test',
            'email' => 'testing@ya.ru',
            'password' => '11112222'
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}
