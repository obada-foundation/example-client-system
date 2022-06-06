<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Obits;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use App\Models\Device;
use Obada\Api\ObitApi;
use Obada\ClientHelper\SaveObitRequest;
use Log;
use Throwable;

class Store extends Handler {
    public function __invoke(Request $request, ObitApi $api) {
        if (!$request->has('device_id')) {
            return response()->json([
                'status'       => 1,
                'errorMessage' => 'Unable to find device'
            ], 404);
        }
        $device = Device::byUsn($request->get('device_id'))->first();
        if (! $device) {
            return response()->json([
                'status'       => 1,
                'errorMessage' => 'Unable to find device'
            ], 404);
        }

        try {
            $clientHelperObit = $api->save(
                (new SaveObitRequest())
                    ->setSerialNumber($device->serial_number)
                    ->setManufacturer($device->manufacturer)
                    ->setPartNumber($device->part_number)
            );

            $device->obit_checksum = $clientHelperObit->getChecksum();
            $device->save();

            return response()->json([
                'status' => 0
            ], 200);
        } catch (Throwable $t) {
            Log::info($t->getMessage());
            Log::info($t->getTraceAsString());
            return response()->json([
                'status'       => 1,
                'errorMessage' => 'Error Saving Client Obit',
                'device'       => $device
            ], 400);
        }
    }
}