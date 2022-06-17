<?php

namespace App\Providers;

use App\ObitManager\ObitManager;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       // $this->app->singleton('ObitManager', function ($app) {
       //     return new ObitManager();
       // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(! in_array(env('APP_ENV'), ['testing', 'local'])) {
            URL::forceScheme('https');
        }
    }
}
