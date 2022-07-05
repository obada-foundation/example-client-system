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

class Send extends Handler {
    public function __invoke(SendRequest $request, string $usn)
    {
        $token = app(Token::class)->create(Auth::user());

        $api = app(NFTApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $req = (new SendNFTRequest)->setReceiver($request->json('recipient'));

        $api->send($usn, $req);

        Device::byUsn($usn)->delete();
    }
}
