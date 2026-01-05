<?php

namespace Sabith\StackcueZat2Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Sabith\StackcueZat2Laravel\StackcueZat2Manager;
use Illuminate\Support\Facades\Log;

class StackcueZat2ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load migrations (only once)
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // FIX: Correct path with capital 'V' in Views
        $this->loadViewsFrom(__DIR__ . '/../Views', 'stackcue-zat2');

        // Publish config
        $this->publishes([
            __DIR__ . '/../../config/stackcue-zat2.php' => config_path('stackcue-zat2.php'),
        ], 'config');

        // Optional: Allow users to publish and override views
        $this->publishes([
            __DIR__ . '/../Views' => resource_path('views/vendor/stackcue-zat2'),
        ], 'stackcue-zat2-views');
    }

    public function register()
    {
        Log::info('StackcueZat2ServiceProvider registered.');

        $this->app->singleton('stackcue-zat2', function ($app) {
            return new StackcueZat2Manager();
        });
    }
}