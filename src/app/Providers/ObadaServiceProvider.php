<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Obada\Api\ObitApi;
use Obada\Api\UtilsApi;
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
        $this->app->bind(Configuration::class, fn() => (new Configuration())->setHost(config('client-helper.host')));

        $this->app->bind(UtilsApi::class, fn() => new UtilsApi(
            new Client(),
            resolve(Configuration::class)
        ));

        $this->app->bind(ObitApi::class, fn() => new ObitApi(
            new Client(),
            resolve(Configuration::class)
        ));
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
