<?php

declare(strict_types=1);

namespace App\Http\Handlers\NFT;

use App\Http\Handlers\Handler;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Obada\Api\NFTApi;
use Obada\ApiException;

class Mint extends Handler {
    public function __invoke(string $usn)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(NFTApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        try {
            $api->mint($usn);
        } catch (ApiException $e) {
            report($e);

            $apiError = json_decode($e->getResponseBody());

            return response()->json([
                'errorMessage' => ucfirst($apiError->error)
            ], 400);
        }
    }
}
