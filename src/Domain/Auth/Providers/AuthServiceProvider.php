<?php

namespace Domain\Auth\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(
            ActionServiceProvider::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}