<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SignInController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\RequestFactories\SignInFormRequestFactory;
use Tests\TestCase;

class SignInControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itPageSuccess(): void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    #[Test]
    public function itHandleSuccess(): void
    {
        $password = '123456789';

        $user = UserFactory::new()->create([
            'email' => 'testing@cutcode.ru',
            'password' => bcrypt($password)
        ]);

        $request = SignInFormRequestFactory::new()->create([
            'email' => $user->email,
            'password' => $password
        ]);

        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function itHandleFail(): void
    {
        $request = SignInFormRequestFactory::new()->create([
            'email' => 'notfound@cutcode.ru',
            'password' => str()->random(10)
        ]);

        $this->post(action([SignInController::class, 'handle']), $request)
            ->assertInvalid(['email']);

        $this->assertGuest();
    }


    #[Test]
    public function itLogoutSuccess(): void
    {
        $user = UserFactory::new()->create([
            'email' => 'testing@cutcode.ru',
        ]);

        $this->actingAs($user)
            ->delete(action([SignInController::class, 'logOut']));


        $this->assertGuest();
    }

    #[Test]
    public function itLogoutGuestMiddlewareFail(): void
    {
        $this->delete(action([SignInController::class, 'logOut']))
            ->assertRedirect(route('home'));
    }

}
