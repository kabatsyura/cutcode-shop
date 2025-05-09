<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Support\SessionRegenerator;

class SignInController extends Controller
{
    public function page(): View
    {
        return view('auth.login');
    }

    public function handle(SignInFormRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Ваш email введен не верно, либо не был ранее создан.',
            ]);
        }

        SessionRegenerator::run();

        return redirect()->intended(route('home'));
    }

    public function logOut(): RedirectResponse
    {
        SessionRegenerator::run(fn() => Auth::logout());

        return redirect()->route('home');
    }
}