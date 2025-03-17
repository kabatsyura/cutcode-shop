<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // NOTE: helpfull in cases, when we forget include Eager loading
        // and solve N+1 problem
        Model::preventLazyLoading(! app()->isProduction());
        // NOTE: call Exception in cases, when we want to save smthng without fillable
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());

        DB::whenQueryingForLongerThan(500, function(Connection $connection) {
            //
        });
    }
}
