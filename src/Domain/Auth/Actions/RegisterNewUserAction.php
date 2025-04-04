<?php

namespace Domain\Auth\Actions;

use App\Events\NewRegistered;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Auth;

final class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(NewUserDTO $data)
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);

        event(new NewRegistered($user));

        Auth::login($user);
    }
}
