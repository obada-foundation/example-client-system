<?php

declare(strict_types=1);

namespace App\Http\Handlers\Accounts;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Illuminate\Support\Facades\Validator;
use Obada\Api\AccountsApi;
use Obada\ClientHelper\MnemonicRequest;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Obada\ClientHelper\WalletExistsError;
use Obada\ApiException;

class ImportWallet extends Handler {
    public function __invoke(Request $request)
    {
        $mnemonic = request()->get('seed_phrase', '');

        $words = explode(' ', $mnemonic);

        if (count($words) == 0) {
            throw new Exception('Mnemonic must exists in session');
        }

        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $req = (new MnemonicRequest)
            ->setMnemonic($mnemonic)
            ->setForce(true);

        try {
            $api->importWallet($req);
        } catch (ApiException $t) {
            report($t);

            return redirect()->back()->withErrors(['seed_phrase' => ucfirst(json_decode($t->getResponseBody())->error)]);
        }

        return redirect()->route('accounts.index')->with('message', 'Existing accounts imported. A new unused account has been added to your list.');
    }
}
