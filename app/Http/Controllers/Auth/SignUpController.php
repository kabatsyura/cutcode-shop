<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SignUpController extends Controller
{
    public function page(): View
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        $dto = NewUserDTO::fromRequest($request);
        $action($dto);

        return redirect()->intended(route('home'));
    }
}
