<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Obada\Api\AccountsApi;
use App\ClientHelper\Token;
use Obada\ClientHelper\NewAccountRequest;

class RegisterOBADAAccount
{
    protected AccountsApi $api;

    protected Token $tokenCreator;

    public function __construct(AccountsApi $api, Token $tokenCreator) 
    {
        $this->api = $api;
        $this->tokenCreator = $tokenCreator;
    }
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $token = $this->tokenCreator->create($event->user);

        $this->api->getConfig()->setAccessToken($token);

        $newAccount = (new NewAccountRequest)
            ->setEmail($event->user->email);

        $this->api->createAccount($newAccount);
    }
}
