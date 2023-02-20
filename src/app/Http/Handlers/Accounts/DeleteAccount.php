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
use Throwable;

class DeleteAccount extends Handler {
    public function __invoke(Request $request, $address)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        try {
            $api->deleteImportedAccount($address);

            return redirect()
                ->back()
                ->with('message', 'Account <strong>' . $address . '</strong> successfully deleted.');
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->withErrors([['account' => 'Cannot delete account with address ' . $address]]);
        }
    }
}
