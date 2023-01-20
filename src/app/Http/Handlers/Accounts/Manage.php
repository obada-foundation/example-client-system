<?php

declare(strict_types=1);

namespace App\Http\Handlers\Accounts;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use function view;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;
use Obada\Api\AccountsApi;

class Manage extends Handler {
    public function __invoke(Request $request)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        return view('accounts.manage');
    }
}
