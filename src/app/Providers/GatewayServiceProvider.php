<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Obada\Api\ObitApi;
use Obada\Configuration;
use GuzzleHttp\Client;

class GatewayServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void {
        $this->app->bind(ObitApi::class, function() {
            $configuration = (new Configuration)
                ->setHost(config('gateway.gateway_host'));

            return new ObitApi(new Client, $configuration);
        });
    }
}
