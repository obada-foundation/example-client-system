<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\ClientHelper\Token;
use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use Obada\Api\AccountsApi;

class Index extends Handler {
    public function __invoke(string $address)
    {
        $user = Auth::user();
        $token = app(Token::class)->create($user);

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        //$balance = $api->balance();

        $devices_count = $user
            ->devices()
            ->byAddress($address)
            ->count();

        return view('devices.index', [
            'address'       => $address,
            'balance'       => 0, //number_format($balance->getBalance(), 16),
            'devices_count' => $devices_count
        ]);
    }
}
