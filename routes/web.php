<?php

use App\Http\Controllers\Auth\AuthSocialController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', HomeController::class)->name('home');

// Route::middleware('web')
//     ->group(function () {
//         Route::get('/', HomeController::class)->name('home');
//     });

// Route::middleware('web')->group(function () {
//     Route::controller(SignInController::class)->group(function () {
//         Route::get('/login', 'page')->name('login');
//         Route::post('/login', 'handle')
//             ->middleware('throttle:auth')
//             ->name('login.handle');
//         Route::delete('/logout', 'logOut')->name('logOut');
//     });

//     Route::controller(SignUpController::class)->group(function () {
//         Route::get('/sign-up', 'page')->name('register');

//         Route::post('/sign-up', 'handle')
//             ->middleware('throttle:auth')
//             ->name('register.handle');
//     });

//     Route::controller(ForgotPasswordController::class)->group(function () {
//         Route::get('/forgot-password', 'page')
//             ->middleware('guest')
//             ->name('forgot');

//         Route::post('/forgot-password', 'handle')
//             ->middleware('guest')
//             ->name('forgot.handle');
//     });

//     Route::controller(ResetPasswordController::class)->group(function () {
//         Route::get('/reset-password/{token}', 'page')
//             ->middleware('guest')
//             ->name('password.reset');

//         Route::post('/reset-password', 'handle')
//             ->middleware('guest')
//             ->name('password-reset.handle');
//     });
//     Route::controller(AuthSocialController::class)->group(function () {
//         Route::get('/auth/socialite/{driver}', 'redirect')
//             ->name('socialite.redirect');

//         Route::get('/auth/socialite/{driver}/callback', 'callback')
//             ->name('socialite.callback');
//     });
// });

// Route::controller(AuthController::class)->group(function () {
//     Route::get('/login', 'index')->name('login');
//     Route::post('/login', 'signIn')
//         ->middleware('throttle:auth')->name('signIn');
//     Route::get('/sign-up', 'signUp')->name('signUp');
//     Route::post('/sign-up', 'store')
//         ->middleware('throttle:auth')->name('store');
//     Route::get('/forgot-password', 'forgot')
//         ->middleware('guest')
//         ->name('password.request');
//     Route::post('/forgot-password', 'forgotPassword')
//         ->middleware('guest')
//         ->name('password.email ');
//     Route::delete('/logout', 'logout')->name('logout');

//     Route::get('/reset-password/{token}', 'reset')
//         ->middleware('guest')
//         ->name('password.reset');

//     Route::post('/reset-password', 'resetPassword')
//         ->middleware('guest')
//         ->name('password.update');

//     Route::get('/auth/github', 'authGithub')
//         ->name('auth.github');

//     Route::get('/auth/github/callback', 'authGithubCallback')
//         ->name('auth.github.callback');
// });

// Route::get('/', HomeController::class)->name('home');