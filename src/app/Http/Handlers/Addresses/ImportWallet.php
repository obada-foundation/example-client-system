<?php

declare(strict_types=1);

namespace App\Http\Handlers\Addresses;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Illuminate\Support\Facades\Validator;
use Obada\Api\AccountsApi;
use Obada\ClientHelper\MnemonicRequest;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Throwable;
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
            ->setMnemonic($mnemonic);

        try {
            $api->importWallet($req);
        } catch (ApiException $t) {
            if ($t->getResponseObject() instanceof WalletExistsError) {
                return redirect()->back()->withErrors(['seed_phrase' => ucfirst($t->getResponseObject()->getError())]);
            }
            
            throw $t;
        }

        return Redirect::route('addresses.index', ['show_data' => 1, 'has_addresses' => 1]);
    }
}
