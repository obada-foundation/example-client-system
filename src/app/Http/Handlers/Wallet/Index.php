<?php

declare(strict_types=1);

namespace App\Http\Handlers\Wallet;

use App\Http\Handlers\Handler;
use function view;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;
use Obada\Api\AccountsApi;

class Index extends Handler {
    public function __invoke()
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $balance = $api->balance();

        return view('wallet.index', [
            'address' => $balance->getAddress(),
            'balance' => $balance->getBalance()
        ]);
    }
}
