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

        $account = $api->account($address);

        return view('devices.index', [
            'address'       => $address,
            'address_short' => substr($address, 0, 10) . '...' . substr($address, -4),
            'balance'       => number_format($account->getBalance(), 16),
            'devices_count' => $account->getNftCount(),
        ]);
    }
}
