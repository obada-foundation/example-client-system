<?php

declare(strict_types=1);

namespace App\Http\Handlers\NFT;

use App\Http\Handlers\Handler;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Obada\Api\NFTApi;
use Throwable;

class MintAll extends Handler {
    public function __invoke(string $address)
    {
        $user = Auth::user();

        $token = app(Token::class)->create($user);

        $api = app(NFTApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $devices = $user
            ->devices()
            ->where('address', $address)
            ->get();

        foreach ($devices as $device) {
            try {
                $api->nft($device->usn);
            } catch (Throwable $t) {
                $api->mint($device->usn);
            }
            sleep(3);
        }

        return redirect()->back();
    }
}
