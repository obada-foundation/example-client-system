<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Obits;

use App\Http\Handlers\Handler;
use Obada\Api\ObitApi;
use Throwable;
use Log;

class FromChain extends Handler {
    public function __invoke(ObitApi $api, $key) {
        try {
            $api->downloadFromChain($key);

            return response()->json([
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