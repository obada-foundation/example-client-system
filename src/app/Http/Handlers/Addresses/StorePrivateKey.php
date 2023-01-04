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
use Obada\ApiException;

class StorePrivateKey extends Handler {
    public function __invoke(Request $request)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        try {
            $api->newAccount();
        } catch (ApiException $e) {
            $newAccountError = json_decode($e->getResponseBody());

            return Redirect::back()
                ->withErrors([['new_account' => $newAccountError->details]]);
        }

        return Redirect::route('addresses.index', ['show_data' => 1, 'has_addresses' => 1]);
    }
}
