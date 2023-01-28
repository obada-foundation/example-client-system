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
use Obada\ApiException;

class Index extends Handler {
    public function __invoke(Request $request)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $accounts = $api->accounts();

        $mnemonic = '';

        try {
            $mnemonic = $api->getMnemonic();
        } catch (ApiException $e) {
            $error = json_decode($e->getResponseBody())->error;

            if (strpos($error, "profile wallet doesn't exists") === false) {
                report($e);
            }
        }

        $proccessAccounts = function (array $accounts) {
            return collect($accounts)
                ->map(function ($account) {
                    $address = $account->getAddress();
                    $name    = $account->getName()
                        ? $account->getName() . ' (' . substr($address, -4) . ')'
                        : substr($address, 0, 10) . '...' . substr($address, -4);

                    return [
                        'address'       => $address,
                        'name'          => $name,
                        'balance'       => $account->getBalance(),
                        'pub_key'       => $account->getPubKey(),
                        'nft_count'     => $account->getNftCount(),
                    ];
                })
                ->toArray();
        };

       $words = explode(" ", $mnemonic->getMnemonic());

       $shortMnemonic = count($words)
            ? sprintf("%s .. %s", $words[0], last($words))
            : "";

        return view('accounts.index', [
            'seed_phrase'       => $mnemonic->getMnemonic(),
            'seed_phrase_short' => $shortMnemonic,
            'add_new_address'   => $request->has('add_new_address'),
            'hd_accounts'       => $proccessAccounts($accounts->getHdAccounts()),
            'imported_accounts' => $proccessAccounts($accounts->getImportedAccounts()),
        ]);
    }
}
