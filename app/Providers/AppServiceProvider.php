<?php

namespace App\Providers;

use App\Events\NewRegistered;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());

        // NOTE: where we call lambda functions and don't use $this we can add 'static' and improve velocity
        if (app()->isProduction()) {
            DB::listen(static function (QueryExecuted $query) {
                if ($query->time > 1000) {
                    logger()
                        ->channel('telegram')
                        ->debug('Query is executed more than 1sec:' . $query->sql, $query->bindings);
                }
            });

            $kernel = app(Kernel::class);
            $kernel->whenRequestLifecycleIsLongerThan(CarbonInterval::seconds(4), static function () {
                logger()
                    ->channel('telegram')
                    ->debug('whenRequestLifecycleIsLongerThan:' . request()->url());
            });
        }
        Event::listen(NewRegistered::class, [SendEmailNewUserListener::class, 'handle']);
        // Event::listen(NewRegistered::class, NewUserNotification::class);
    }
}
