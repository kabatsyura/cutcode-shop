<?php

namespace Tests\Feature\App\HTTP\Controllers;

use App\Events\NewRegistered;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\AuthController;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\RequestFactories\SignInFormRequestFactory;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function indexTest(): void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    #[Test]
    public function signUpTest(): void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    #[Test]
    public function forgotTest(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    #[Test]
    public function signInTest(): void
    {
        $password = '11112222';

        $user = UserFactory::new()->create([
            'email' => 'test@crmme.ru',
            'password' => bcrypt($password),
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password,
        ]);

        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function logoutTest(): void
    {
        $user = UserFactory::new()->create([
            'email' => 'test@crmme.ru'
        ]);

        $response = $this->actingAs($user)
            ->delete(action([SignInController::class, 'logOut']));
        $response->assertRedirect();

        $this->assertGuest();
    }

    #[Test]
    public function storeTest(): void
    {
        Event::fake();
        Notification::fake();

        $body = SignUpFormRequest::factory()->create([
            'email' => 'test@ya.ru',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $userEmail = $body['email'];

        $this->assertDatabaseMissing(
            table: 'users',
            data: ['email' => $userEmail]
        );

        $response = $this->post(
            uri: action([SignUpController::class, 'handle']),
            data: $body
        );

        $response
            ->assertValid()
            ->assertRedirect(route('home'));

        $user = User::where('email', $userEmail)->first();

        $this->assertModelExists($user);
        $this->assertDatabaseHas(
            table: 'users',
            data: ['email' => $userEmail]
        );

        Event::assertDispatched(NewRegistered::class);
        Event::assertListening(NewRegistered::class, SendEmailNewUserListener::class);

        $event = new NewRegistered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);
        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);
    }
}
