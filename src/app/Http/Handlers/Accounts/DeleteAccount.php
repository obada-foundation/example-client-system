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

class DeleteAccount extends Handler {
    public function __invoke(Request $request, $address)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        try {
            return response()->json([
                'status' => 0,
                'devices' => []
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'errorMessage' => 'message'
            ], 400);
        }
    }
}
