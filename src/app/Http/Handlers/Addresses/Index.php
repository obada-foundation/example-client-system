<?php

declare(strict_types=1);

namespace App\Http\Handlers\Addresses;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use function view;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;
use Obada\Api\AccountsApi;

class Index extends Handler {
    public function __invoke(Request $request)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $balance = $api->balance();

        $address = $balance->getAddress();

        return view('addresses.index', [
            'address' => $address,
            'address_short' => substr($address, 0, 10) . '...' . substr($address, -4),
            'seed_phrase' => 'suggest quit betray lunar direct agent trial royal range feel spare awake',
            'seed_phrase_short' => 'suggest ... awake',
            'balance' => $balance->getBalance(),
            'show_data' => $request->has('show_data'),
            'add_new_address' => $request->has('add_new_address'),
            'has_addresses' => $request->has('has_addresses'),
            'has_other_addresses' => $request->has('has_other_addresses')
        ]);
    }
}
