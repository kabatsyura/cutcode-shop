<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    private function testingCredentials(): array
    {
        return [
            'email' => 'testing@cutcode.ru'
        ];
    }

    #[Test]
    public function itPageSuccess(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    #[Test]
    public function itHandleSuccess(): void
    {
        $user = UserFactory::new()->create($this->testingCredentials());

        $this->post(action([ForgotPasswordController::class, 'handle']), $this->testingCredentials())
            ->assertRedirect();

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    #[Test]
    public function itHandleFail(): void
    {
        $this->assertDatabaseMissing('users', $this->testingCredentials());

        $this->post(action([ForgotPasswordController::class, 'handle']), $this->testingCredentials())
            ->assertInvalid(['email']);

        Notification::assertNothingSent();
    }
}
