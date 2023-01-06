<?php

declare(strict_types=1);

namespace App\Http\Handlers\Wallet;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;
use Obada\Api\AccountsApi;
use Obada\ClientHelper\SendCoinsRequest;
use Obada\ApiException;

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

        try {
            $api->sendCoins($address, $req);
        } catch (ApiException $e) {
            report($e);

            $apiError = json_decode($e->getResponseBody());
            
            return redirect()->back()->withInput()->withErrors(['error' => $apiError->error]);
        }

        return redirect()->back();
    }
}
