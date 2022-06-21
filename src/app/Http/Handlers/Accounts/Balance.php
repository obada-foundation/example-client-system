<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Accounts;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;
use Obada\Api\AccountsApi;

class Balance extends Handler {
    public function __invoke()
    {
        $tokenCreator = app(Token::class);

        $token = $tokenCreator->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        return response()->json($api->balance());
    }
}