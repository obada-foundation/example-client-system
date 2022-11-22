<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Obada\Api\AccountsApi;
use Obada\Api\ObitApi;
use Obada\Api\UtilsApi;
use Obada\Api\KeysApi;
use Obada\Configuration;
use App\ClientHelper\Token;

class ObadaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Token::class, fn () => new Token(
            config('client-helper.token.kid'),
            config('client-helper.token.private_key_path')
        ));
    
        $this->app->bind(Configuration::class, fn() => 
            (new Configuration())
                    ->setHost(config('client-helper.host'))
        );

        $this->app->bind(UtilsApi::class, fn() => new UtilsApi(
            new Client(),
            resolve(Configuration::class)
        ));

        $this->app->bind(KeysApi::class, fn() => new KeysApi(
            new Client(),
            resolve(Configuration::class)
        ));

        $this->app->bind(ObitApi::class, fn() => new ObitApi(
            new Client(),
            resolve(Configuration::class)
        ));

        $this->app->bind(AccountsApi::class, fn() => new AccountsApi(
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
