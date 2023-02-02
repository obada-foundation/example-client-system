<?php

declare(strict_types=1);

namespace App\Http\Handlers\NFT\Transfer;

use App\Http\Handlers\Handler;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Obada\Api\NFTApi;
use Obada\ClientHelper\SendNFTRequest;
use App\Http\Requests\NFT\SendRequest;
use App\Models\Device;
use Obada\ApiException;
use Illuminate\Support\Facades\Redis;

class Send extends Handler {
    public function __invoke(SendRequest $request, string $usn)
    {
        $user  = Auth::user();
        $token = app(Token::class)->create($user);

        $api = app(NFTApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $req = (new SendNFTRequest)
            ->setReceiver($request->json('recipient'));

        try {
            $device = $user->devices()->byUsn($usn)->first();

            if (! $device) {
                return response()->json([
                    'errorMessage' => 'Not authorized'
                ], 401);
            }

            $api->send($usn, $req);

            Redis::subscribe(['nft.transfered'], function ($did) use ($usn, $device) {
                if ($did === $device->obit_did) {
                    Log::info('NFT ' . $did . ' was transfered');
                    $device->delete();
                    exit(0);
                }
            });
        } catch (ApiException $e) {
            $apiError = json_decode($e->getResponseBody());

            return response()->json([
                'errorMessage' => ucfirst($apiError->error)
            ], 400);
        }
    }
}
