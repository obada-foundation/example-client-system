<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Obits;

use App\Http\Handlers\Handler;
use Obada\Api\NFTApi;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\ClientHelper\Token;

class ToChain extends Handler {
    public function __invoke(NFTApi $api, $key) {
        try {
            $tokenCreator = app(Token::class);

            $token = $tokenCreator->create(Auth::user());
            
            $api->getConfig()->setAccessToken($token);

            $api->mint($key);

            return response()->json([
                'status' => 0
            ], 200);
        } catch (Throwable $t) {
            Log::info($t->getMessage());
            Log::info($t->getTraceAsString());

            return response()->json([
                'status'       => 1,
                'errorMessage' => 'Cannot mint NFT',
            ], 200);
        }
    }
}