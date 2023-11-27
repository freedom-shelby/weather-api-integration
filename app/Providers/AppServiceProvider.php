<?php

namespace App\Providers;

use App\Services\API\Weather\V1\WeatherV1Service;
use App\Services\API\Weather\WeatherInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $version = Route::getCurrentRoute()?->getPrefix() ?: env('API_LSV');

        // Bind the appropriate implementation based on the version
        if ($version === 'v1') {
            app()->bind(WeatherInterface::class, WeatherV1Service::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
