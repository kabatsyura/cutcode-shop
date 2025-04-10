<?php

namespace Domain\Catalog\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    protected $policies = [];
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(ActionServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
