<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $token;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->create();
        $this->token = Password::createToken($this->user);
    }

    #[Test]
    public function itPageSuccess(): void
    {
        $response = $this->get(action([ResetPasswordController::class, 'page'], ['token' => $this->token]));

        $response->assertOk();
        $response->assertViewIs('auth.reset-password');
    }

    #[Test]
    public function itHandle(): void
    {
        $password = '1234567890';
        $password_confirmation = '1234567890';

        Password::shouldReceive('reset')
            ->once()
            ->withSomeofArgs([
                'email' => $this->user->email,
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'token' => $this->token
            ])
            ->andReturn(Password::PASSWORD_RESET);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'email' => $this->user->email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
            'token' => $this->token
        ]);

        $response->assertRedirect(action([HomeController::class]));
    }

}
