<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'signIn')->name('signIn');
    Route::get('/sign-up', 'signUp')->name('signUp');
    Route::post('/sign-up', 'store')->name('store');
    Route::get('/forgot-password', 'forgot')
        ->middleware('guest')
        ->name('password.request');
    Route::post('/forgot-password', 'forgotPassword')
        ->middleware('guest')
        ->name('password.email ');
    Route::delete('/logout', 'logout')->name('logout');

    Route::get('/reset-password/{token}', 'reset')
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', 'resetPassword')
        ->middleware('guest')
        ->name('password.update');

    Route::get('/auth/github', 'authGithub')
        ->name('auth.github');

    Route::get('/auth/github/callback', 'authGithubCallback')
        ->name('auth.github.callback');
});

Route::get('/', HomeController::class)->name('home');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__ . '/auth.php';

// https://github.com/login/oauth/authorize?client_id=Ov23lixDFlcDtev4QOL9&redirect_uri=https%3A%2F%2Fshop.kabatsyura.ru%2Fauth%2Fgithub%2Fcallback&scope=user%3Aemail&response_type=code&state=DKSigqocOtQyOY83BsMwMOyVpeZyKU35XZ2QZw6K
