<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'signIn')
        ->middleware('throttle:auth')->name('signIn');
    Route::get('/sign-up', 'signUp')->name('signUp');
    Route::post('/sign-up', 'store')
        ->middleware('throttle:auth')->name('store');
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

