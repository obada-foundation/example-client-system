<?php

declare(strict_types=1);

namespace App\Http\Handlers\Accounts;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Obada\Api\AccountsApi;
use Obada\ClientHelper\AccountRequest;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Obada\ApiException;

class StoreAccount extends Handler {
    public function __invoke(Request $request)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        try {
            $api->newAccount(new AccountRequest);
        } catch (ApiException $e) {
            $newAccountError = json_decode($e->getResponseBody());

            return Redirect::back()
                ->withErrors([['new_account' => $newAccountError->error]]);
        }

        return Redirect::route('accounts.index');
    }
}
