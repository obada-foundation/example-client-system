<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Obits;

use App\Http\Handlers\Handler;
use Obada\Api\NFTApi;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;

class FromChain extends Handler {
    public function __invoke(NFTApi $api, $key) {
        try {
            $tokenCreator = app(Token::class);

            $token = $tokenCreator->create(Auth::user());
            
            $api->getConfig()->setAccessToken($token);

            $result = $api->nft($key);

            return response()->json([
                'nft' => $result,
                'status' => 0
            ], 200);
        } catch (Throwable $t) {
            Log::info($t->getMessage());
            Log::info($t->getTraceAsString());

            return response()->json([
                'status'       => 1,
                'errorMessage' => 'Cannot download NFT from chain',
            ], 200);
        }
    }
}