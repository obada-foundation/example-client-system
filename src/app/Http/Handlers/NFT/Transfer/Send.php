<?php

declare(strict_types=1);

namespace App\Http\Handlers\NFT\Transfer;

use App\Http\Handlers\Handler;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Obada\Api\NFTApi;
use Obada\ClientHelper\SendNFTRequest;
use App\Http\Requests\NFT\SendRequest;
use App\Models\Device;
use Obada\ApiException;

class Send extends Handler {
    public function __invoke(SendRequest $request, string $usn)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(NFTApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $req = (new SendNFTRequest)->setReceiver($request->json('recipient'));

        try {
            $api->send($usn, $req);
        } catch (ApiException $e) {
            report($e);

            $apiError = json_decode($e->getResponseBody());

            return response()->json([
                'errorMessage' => ucfirst($apiError->error)
            ], 400);
        }

        Device::byUsn($usn)->delete();
    }
}
