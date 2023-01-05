<?php

declare(strict_types=1);

namespace App\Http\Handlers\Accounts;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use function view;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;
use Obada\Api\AccountsApi;
use Obada\Api\KeysApi;

class Index extends Handler {
    public function __invoke(Request $request)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $accounts = [];

        if ($request->has('show_data')) {
            $accounts = $api->accounts()->getData();
        }

        $accounts = collect($accounts)
            ->map(function ($account) {

                $address = $account->getAddress();

                return [
                    'address'       => $address,
                    'short_address' => substr($address, 0, 10) . '...' . substr($address, -4),
                    'balance'       => $account->getBalance(),
                    'pub_key'       => $account->getPubKey(),
                    'nft_count'     => $account->getNftCount(),
                ];
            })
            ->toArray();

        return view('accounts.index', [
            'seed_phrase'         => 'suggest quit betray lunar direct agent trial royal range feel spare awake',
            'seed_phrase_short'   => 'suggest ... awake',
            'balance'             => 0,//$balance->getBalance(),
            'show_data'           => $request->has('show_data'),
            'add_new_address'     => $request->has('add_new_address'),
            'has_accounts'        => count($accounts),
            'accounts'            => $accounts,
        ]);
    }
}
