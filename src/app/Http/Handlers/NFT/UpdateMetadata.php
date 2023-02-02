<?php

declare(strict_types=1);

namespace App\Http\Handlers\NFT;

use App\Http\Handlers\Handler;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Obada\Api\NFTApi;
use Obada\ApiException;

class UpdateMetadata extends Handler {
    public function __invoke(string $usn)
    {
        $user   = Auth::user();
        $device = $user->devices()->byUsn($usn)->first();

        if (! $device) {
            return response()->json([
                'errorMessage' => 'Not authorized'
            ], 401);
        }

        $token = app(Token::class)->create($user);

        try {
            $api = app(NFTApi::class);
            $api->getConfig()
                ->setAccessToken($token);
    
            $api->updateMetadata($usn);

            Redis::subscribe(['nft.metadata.updated'], function ($did) use ($usn, $device) {
                Log::info('NFT metadata for ' . $did . ' was updated');
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
