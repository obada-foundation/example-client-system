<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Obada\Api\ObitApi;
use Obada\Configuration;

class ObadaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('obada_client',function() {
            return new ObitApi(
                new Client(),
                (new Configuration())->setHost('client-helper')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
