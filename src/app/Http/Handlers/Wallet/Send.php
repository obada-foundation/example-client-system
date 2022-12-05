<?php

declare(strict_types=1);

namespace App\Http\Handlers\Wallet;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;
use Obada\Api\AccountsApi;
use Obada\ClientHelper\SendCoinsRequest;

class Send extends Handler {
    public function __invoke($address)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $req = (new SendCoinsRequest)
            ->setDenom('obd')
            ->setAmount(request()->get('amount'))
            ->setRecepientAddress(request()->get('recepient_address'));

        $api->sendCoins($address, $req);

        return redirect()->back();
    }
}
