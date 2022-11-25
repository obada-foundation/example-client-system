<?php

declare(strict_types=1);

namespace App\Http\Handlers\Addresses;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Obada\Api\AccountsApi;
use Obada\ClientHelper\ImportAccountRequest;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Obada\ApiException;

class ImportAccount extends Handler {
    public function __invoke(Request $request)
    {
        if (! $request->hasFile('key_value')) {
            return redirect()->back()->withErrors(['key_value' => 'Missing private key file']);
        }

        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $req = (new ImportAccountRequest)
            ->setPrivateKey($request->file('key_value')->getContent());

        try {
            $api->importAccount($req);
        } catch (ApiException $e) {
            report($e);
            
            return redirect()->back()->withErrors(['key_value' => 'Invalid private key file']);
        }

        return redirect()->route('addresses.index', ['show_data' => 1, 'has_addresses' => 1]);
    }
}
