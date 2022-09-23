<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\ClientHelper\Token;
use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use Obada\Api\AccountsApi;

class Index extends Handler {
    public function __invoke()
    {
        $user = Auth::user();
        $token = app(Token::class)->create($user);

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $balance = $api->balance();


        $devices_count = $user->devices()->count();

        return view('devices.index', [
            'address' => $balance->getAddress(),
            'balance' => $balance->getBalance(),
            'devices_count' => $devices_count
        ]);
    }
}
