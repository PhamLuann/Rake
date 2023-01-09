<?php

namespace PhamLuann\Rake;

use Illuminate\Support\ServiceProvider;

class RakeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('rake.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'rake');

        // Register the main class to use with the facade
        $this->app->singleton('rake', function () {
            return new Rake;
        });
    }
}
