<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use File;
use View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        foreach (File::directories(app_path('Modules')) as $moduleDir) {
            View::addlocation($moduleDir);
        }
    }
}
