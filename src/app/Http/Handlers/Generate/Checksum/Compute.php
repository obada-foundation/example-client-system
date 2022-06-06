<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Generate\Checksum;

use App\Http\Handlers\Handler;
use App\Http\Requests\ComputeChecksumRequest;
use Obada\ClientHelper\GenerateObitChecksumRequest;
use Obada\Api\UtilsApi;
use Throwable;
use Log;

class Compute extends Handler {
    public function __invoke(ComputeChecksumRequest $request, UtilsApi $api) {
        try {
            $resp = $api->generateChecksum(
                (new GenerateObitChecksumRequest())
                    ->setSerialNumber($request->get('serial_number'))
                    ->setManufacturer($request->get('manufacturer'))
                    ->setPartNumber($request->get('part_number'))
                    ->setMetadataUri($request->get('metadata_uri'))
                    ->setMetadataUriHash($request->get('metadata_uri_hash'))
                    ->setTrustAnchorToken($request->get('trust_anchor_token'))
            );

            return response()->json([
                'checksum'    => $resp->getChecksum(),
                'compute_log' => $resp->getComputeLog()
            ], 200);

        } catch (Throwable $t) {
            Log::error("Cannot compute checksum of given data", [
                'error'   => $t->getMessage(),
                'data'    => $request->all(),
                'context' => $t->getTraceAsString()
            ]);

            return response()->json([
                'errorMessage' => 'internal error'
            ], 500);
        }
    }
}