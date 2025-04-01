<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\AuthSocialController;
use App\Http\Controllers\Auth\SocialAuthController;
use Database\Factories\UserFactory;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SocialAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private function mockSocialiteCallback(string|int $githubId): MockInterface
    {
        $user = $this->mock(SocialiteUser::class, function (MockInterface $m) use($githubId) {
            $m->shouldReceive('getId')
                ->once()
                ->andReturn($githubId);

            $m->shouldReceive('getName')
                ->once()
                ->andReturn(str()->random(10));

            $m->shouldReceive('getEmail')
                ->once()
                ->andReturn('testing@cutcode.ru');
        });

        Socialite::shouldReceive('driver->user')
            ->once()
            ->andReturn($user);

        return $user;
    }

    private function callbackRequest(): TestResponse
    {
        return $this->get(
            action(
                [AuthSocialController::class, 'callback'],
                ['driver' => 'github']
            )
        );
    }

    #[Test]
    public function itGithubRedirectSuccess(): void
    {
        $this->get(
            action(
                [AuthSocialController::class, 'redirect'],
                ['driver' => 'github']
            )
        )->assertRedirectContains('github.com');
    }

    #[Test]
    public function itDriverNotFoundException(): void
    {
        $this->expectException(DomainException::class);

        $this
            ->withoutExceptionHandling()
            ->get(
                action(
                    [AuthSocialController::class, 'redirect'],
                    ['driver' => 'vk']
                )
            );

        $this
            ->withoutExceptionHandling()
            ->get(
                action(
                    [AuthSocialController::class, 'callback'],
                    ['driver' => 'vk']
                )
            );
    }


    #[Test]
    public function itGithubCallbackCreatedUserSuccess(): void
    {
        $githubId = str()->random(10);
        $this->assertDatabaseMissing('users', [
            'github_id' => $githubId
        ]);

        $this->mockSocialiteCallback($githubId);

        $this->callbackRequest()
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'github_id' => $githubId
        ]);
    }

    #[Test]
    public function itAuthenticatedByExistingUser(): void
    {
        $githubId = str()->random(10);

        UserFactory::new()->create([
            'github_id' => $githubId
        ]);

        $this->assertDatabaseHas('users', [
            'github_id' => $githubId
        ]);

        $this->mockSocialiteCallback($githubId);

        $this->callbackRequest()
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }

}
