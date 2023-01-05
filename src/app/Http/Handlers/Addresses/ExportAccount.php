<?php

declare(strict_types=1);

namespace App\Http\Handlers\Addresses;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Obada\Api\AccountsApi;
use Obada\ClientHelper\ExportAccountRequest;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Obada\ApiException;

class ExportAccount extends Handler {
    public function __invoke(Request $request)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $req = (new ExportAccountRequest)
            ->setAddress($request->get('address'))
            ->setPassphrase($request->get('passphrase', ""));

        $resp = $api->exportAccount($req);
    }
}
