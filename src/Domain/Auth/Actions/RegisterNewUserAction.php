<?php

namespace Domain\Auth\Actions;

use App\Events\NewRegistered;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Auth;

final class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(string $name, string $email, string $password)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        event(new NewRegistered($user));

        Auth::login($user);
    }
}