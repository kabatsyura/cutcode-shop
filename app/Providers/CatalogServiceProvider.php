<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorters\Sorter;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app(FilterManager::class)->registersFilters([
            new PriceFilter(),
            new BrandFilter()
        ]);

        $this->app->bind(Sorter::class, function () {
            return new Sorter(['title', 'price']);
        });
    }
}
