<?php

namespace Tests\Feature\App\HTTP\Controllers;

use App\Events\NewRegistered;
use App\Http\Controllers\AuthController;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
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
        $this->get(action([AuthController::class, 'index']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.index');
    }

    #[Test]
    public function signUpTest(): void
    {
        $this->get(action([AuthController::class, 'signUp']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    #[Test]
    public function forgotTest(): void
    {
        $this->get(action([AuthController::class, 'forgot']))
            ->assertOk()
            ->assertViewIs('auth.forgo t-password');
    }

    #[Test]
    public function signInTest(): void
    {
        $password = '11112222';

        $user = User::factory()->create([
            'email' => 'test@crmme.ru',
            'password' => bcrypt($password),
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password,
        ]);

        $response = $this->post(action([AuthController::class, 'signIn']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function logoutTest(): void
    {
        $user = User::factory()->create([
            'email' => 'test@crmme.ru'
        ]);

        $response = $this->actingAs($user)->delete(action([AuthController::class, 'logout']));
        $response->assertRedirect();

        $this->assertGuest();
    }

    #[Test]
    public function storeTest(): void
    {
        Event::fake();
        Notification::fake();

        $body = SignUpFormRequest::factory()->create([
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $userEmail = $body['email'];

        $this->assertDatabaseMissing(
            table: 'users',
            data: ['email' => $userEmail]
        );

        $response = $this->post(
            uri: action([AuthController::class, 'store']),
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
