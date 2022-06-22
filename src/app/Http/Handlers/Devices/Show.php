<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use Obada\Api\ObitApi;
use Obada\Api\UtilsApi;
use Obada\ClientHelper\GenerateObitDIDRequest;
use Throwable;
use Log;

class Show extends Handler
{
    public function __invoke(ObitApi $obitApi, UtilsApi $utilsApi, $usn)
    {
        $device = Auth::user()->devices()->with('documents')
            ->byUsn($usn)
            ->first();

        if (!$device) {
            return redirect()->route('devices.index');
        }

        try {
            $obit = $obitApi->get($usn);
        } catch (Throwable $t) {
            $obit = [];
            Log::info($t->getMessage());
        }

        $usn_data = null;
        try {
            $resp = $utilsApi->generateDID(
                (new GenerateObitDIDRequest())
                    ->setSerialNumber($device->serial_number)
                    ->setManufacturer($device->manufacturer)
                    ->setPartNumber($device->part_number)
            );

            $usn_data = (object) [
                'did'                => $resp->getDid(),
                'usn'                => $resp->getUsn(),
                'usn_base58'         => $resp->getUsnBase58(),
                'serial_number_hash' => $resp->getSerialNumberHash()
            ];
        } catch (Throwable $t) {
            Log::error("Cannot generate obit", [
                'error'   => $t->getMessage(),
                'context' => $t->getTraceAsString()
            ]);
        }

        return view('devices.show', [
            'device_id' => $usn,
            'device' => $device,
            'obit' => $obit,
            'usn_data' => $usn_data
        ]);
    }
}
