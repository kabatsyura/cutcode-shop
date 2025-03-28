<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthSocialController extends Controller
{
    public function redirect(string $driver)
    {
        try {
            return Socialite::driver($driver)->redirect(route('auth.socialite.callback', ['driver' => $driver]));
        } catch (Throwable $e) {
            throw new DomainException('Данный вид авторизации не поддерживается.');
        }
    }

    public function callback(string $driver): RedirectResponse
    {
        if ($driver !== 'github') {
            throw new DomainException('Данный драйвер не поддерживается.');
        }
        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            $driver .  '_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name ?? $githubUser->getEmail(),
            'email' => $githubUser->getEmail(),
            'password' => bcrypt(str()->random(10))
        ]);

        auth()->login($user);

        return redirect()
            ->intended(route('home'));
    }
}