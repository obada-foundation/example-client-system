<?php

declare(strict_types=1);

namespace App\Http\Handlers\NFT;

use App\Http\Handlers\Handler;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Obada\Api\NFTApi;
use Obada\ApiException;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class Mint extends Handler {
    public function __invoke(string $usn)
    {
        $user  = Auth::user();
        $token = app(Token::class)->create($user);

        $api = app(NFTApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        try {
            $device = $user->devices()->byUsn($usn)->first();

            if (! $device) {
                return response()->json([
                    'errorMessage' => 'Not authorized'
                ], 401);
            }

            $api->mint($usn);

            Redis::subscribe(['nft.minted'], function ($did) use ($usn, $device) {
                Log::info('NFT ' . $did . ' was minted');
                exit(0);
            });
        } catch (ApiException $e) {
            $apiError = json_decode($e->getResponseBody());

            return response()->json([
                'errorMessage' => ucfirst($apiError->error)
            ], 400);
        }
    }
}
