<?php
namespace Sabith\StackcueZat2Laravel\Providers;


use Illuminate\Support\ServiceProvider;
use Sabith\StackcueZat2Laravel\StackcueZat2Manager;
use Illuminate\Support\Facades\Log;


class StackcueZat2ServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../views', 'stackcue-zat2');
    // Load migrations
    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // Optionally publish views
        // $this->publishes([
        //     __DIR__ . '/../views' => resource_path('views/vendor/stackcue-zat2'),
        // ], 'stackcue-zat2-views');

        $this->publishes([
            __DIR__.'/../../config/stackcue-zat2.php' => config_path('stackcue-zat2.php'),
        ], 'config');
    }

    public function register()
    {
        Log::info('StackcueZat2ServiceProvider registered.'); // Debugging

        // Bind the manager class to the container
        $this->app->singleton('stackcue-zat2', function ($app) {
            return new StackcueZat2Manager();
        });
    }
}
