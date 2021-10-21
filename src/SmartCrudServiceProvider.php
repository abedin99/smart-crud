<?php

namespace Abedin99\SmartCrud;

use Illuminate\Support\ServiceProvider;

class SmartCrudServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'smartcrud');

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