<?php

namespace Abedin99\SmartCrud;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\AliasLoader;

class SmartCrudServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/configs/smartcrud.php','smartcrud');        
        
        $this->app->singleton('smartcrud', function ()
        {
            return true;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'smartcrud');

        $this->publishes([__DIR__.'/config/smartcrud.php' => config_path('smartcrud.php')],'smartcrud_config');
        $this->publishes([__DIR__.'/database' => base_path('database')],'smartcrud_migration');

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\SmartCrudInstallCommand::class,
        ]);
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Console\SmartCrudInstallCommand::class];
    }
}