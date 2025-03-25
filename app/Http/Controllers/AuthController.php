<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('auth.index');
    }

    public function signUp(): View
    {
        return view('auth.sign-up');
    }

    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function signIn(SignInFormRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Ваш email введен не верно, либо не был ранее создан.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }
}
