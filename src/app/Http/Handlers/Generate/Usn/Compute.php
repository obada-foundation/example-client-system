<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Generate\Usn;

use App\Http\Handlers\Handler;
use App\Http\Requests\ComputeUsnRequest;
use Obada\ClientHelper\GenerateObitDIDRequest;
use Obada\Api\UtilsApi;
use Throwable;
use Log;

class Compute extends Handler {
    public function __invoke(ComputeUsnRequest $request, UtilsApi $api)
    {
        try {
            $resp = $api->generateDID(
                (new GenerateObitDIDRequest())
                    ->setSerialNumber($request->get('serial_number'))
                    ->setManufacturer($request->get('manufacturer'))
                    ->setPartNumber($request->get('part_number'))
            );

            return response()->json([
                'did'                => $resp->getDid(),
                'usn'                => $resp->getUsn(),
                'usn_base58'         => $resp->getUsnBase58(),
                'serial_number_hash' => $resp->getSerialNumberHash()
            ], 200);

        } catch (Throwable $t) {
            Log::error("Cannot generate obit", [
                'error'   => $t->getMessage(),
                'context' => $t->getTraceAsString()
            ]);

            return response()->json([
                'errorMessage' => 'internal error'
            ], 500);
        }
    }
}
