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

        $accounts = $api->accounts();
        $words    = explode(' ', session()->get('mnemonic', ''));

        $proccessAccounts = function (array $accounts) {
            return collect($accounts)
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
        };

        return view('accounts.index', [
            'seed_phrase'       => session()->get('mnemonic'),
            'seed_phrase_short' => $words[0] . ' ... ' . last($words),
            'add_new_address'   => $request->has('add_new_address'),
            'hd_accounts'       => $proccessAccounts($accounts->getHdAccounts()),
            'imported_accounts' => $proccessAccounts($accounts->getImportedAccounts()),
        ]);
    }
}
