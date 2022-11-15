<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Octane\Facades\Octane;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        Octane::tick('simple-ticker',
            fn () => Log::info('OCTANE TICK.', ['timestamp' => now()])
        )->seconds(10)->immediate();
        */
        Octane::tick(
            'cache-last-random-number',
            function () {
                Cache::store('octane')
                ->put('last-random-number', rand(1, 1000));

            }
        )->seconds(5)->immediate();
    }
}
