<?php
namespace Sabith\StackcueZat2Laravel\Providers;


use Illuminate\Support\ServiceProvider;

class StackcueZat2ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../views', 'stackcue-zat2');

        // Optionally publish views
        $this->publishes([
            __DIR__ . '/../views' => resource_path('views/vendor/stackcue-zat2'),
        ], 'stackcue-zat2-views');
    }

    public function register()
    {
        // Register any package services
    }
}
