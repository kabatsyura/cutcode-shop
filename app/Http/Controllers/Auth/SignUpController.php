<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SignUpController extends Controller
{
    public function page(): View
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        $action(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );

        return redirect()->intended(route('home'));
    }
}
