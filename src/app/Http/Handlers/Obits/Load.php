<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Obits;

use App\Http\Handlers\Handler;
use Obada\Api\ObitApi;
use Throwable;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Log;

class Load extends Handler {
    public function __invoke(ObitApi $api, $key) {
        try {
            $tokenCreator = app(Token::class);

            $token = $tokenCreator->create(Auth::user());
            
            $api->getConfig()->setAccessToken($token);

            $result = $api->get($key);

            return response()->json([
                'status' => 0,
                'obit'   => $result
            ], 200);
        } catch (Throwable $t) {
            Log::info($t->getMessage());
            return response()->json([
                'status'       => 1,
                'errorMessage' => 'Error Getting Client Obit'
            ], 400);
        }
    }
}