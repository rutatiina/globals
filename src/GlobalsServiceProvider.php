<?php

namespace Rutatiina\Globals;

use Illuminate\Support\ServiceProvider;

class GlobalsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');

        //$this->loadViewsFrom(__DIR__.'/resources/views', 'expense');
        //$this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Rutatiina\Globals\Http\Controllers\GlobalsController');
    }
}
