<?php

namespace App\Providers;

use App\Http\Controllers\WeatherController;
use App\Services\ApiService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ApiService::class, function () {
            return new ApiService('https://api.open-meteo.com/v1');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(function () {
                Route::get('/weather', [WeatherController::class, 'getForecast']);
            });
    }
}
