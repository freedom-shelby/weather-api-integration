<?php

namespace App\Providers;

use App\Services\API\ExternalServices\AirQuality\IQAirService;
use App\Services\API\ExternalServices\Weather\WeatherstackService;
use App\Services\API\Weather\V1\WeatherV1Service;
use App\Services\API\Weather\WeatherInterface;
use GuzzleHttp\Client;
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

        $this->app->singleton(WeatherstackService::class, fn() => new WeatherstackService(new Client()));
        $this->app->singleton(IQAirService::class, fn() => new IQAirService(new Client()));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
