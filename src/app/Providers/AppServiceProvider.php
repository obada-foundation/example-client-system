<?php

namespace App\Providers;

use App\ObitManager\ObitManager;
use Illuminate\Support\Facades\URL;
use App\ClientHelper\Token;
use Illuminate\Support\ServiceProvider;
use Obada\Api\AccountsApi;
use Obada\Configuration;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(! in_array(env('APP_ENV'), ['testing'])) {
            URL::forceScheme('https');
        }
    }
}
