<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Events\NewRegistered;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\RequestFactories\SignUpFormRequestFactory;
use Tests\TestCase;

class SignUpControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = SignUpFormRequestFactory::new()->create([
            'email' => 'testing@cutcode.ru',
            'password' => '1234567890',
            'password_confirmation' => '1234567890'
        ]);
    }

    #[Test]
    private function request(): TestResponse
    {
        return $this->post(
            action([SignUpController::class, 'handle']),
            $this->request
        );
    }

    #[Test]
    private function findUser(): User
    {
        return User::query()
            ->where('email', $this->request['email'])
            ->first();
    }

    #[Test]
    public function itPageSuccess(): void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    #[Test]
    public function itValidationSuccess(): void
    {
        $this->request()
            ->assertValid();
    }

    #[Test]
    public function itShouldFailValidationOnPasswordConfirm(): void
    {
        $this->request['password'] = '123';
        $this->request['password_confirmation'] = '1234';

        $this->request()
            ->assertInvalid(['password']);
    }

    #[Test]
    public function itUserCreatedSuccess(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => $this->request['email']
        ]);

        $this->request();

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);
    }

    #[Test]
    public function itShouldFailValidationOnUniqueEmail(): void
    {
        UserFactory::new()->create([
            'email' => $this->request['email']
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);

        $this->request()
            ->assertInvalid(['email']);
    }

    #[Test]
    public function itRegisteredEventAndListenersDispatched(): void
    {
        Event::fake();

        $this->request();

        Event::assertDispatched(NewRegistered::class);
        Event::assertListening(
            NewRegistered::class,
            SendEmailNewUserListener::class
        );
    }

    #[Test]
    public function itNotificationSent(): void
    {
        $this->request();

        Notification::assertSentTo(
            $this->findUser(),
            NewUserNotification::class
        );
    }


    #[Test]
    public function itUserAuthenticatedAfterAndRedirected(): void
    {
        $this->request()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($this->findUser());
    }
}
