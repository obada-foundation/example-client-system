<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices\Import;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use Obada\ClientHelper\GenerateObitDIDRequest;
use App\Events\DeviceSaved;
use Obada\Api\UtilsApi;
use App\Models\Device;

class HandleImport extends Handler {
    public function __invoke(UtilsApi $utilsApi, string $address)
    {
        $importData = explode(PHP_EOL, request()->get('csv'));

        foreach ($importData as $importDeviceStr) {
            $importDevice = str_getcsv($importDeviceStr);

            $did = $utilsApi->generateDID(
                (new GenerateObitDIDRequest())
                    ->setSerialNumber($importDevice[2])
                    ->setManufacturer($importDevice[0])
                    ->setPartNumber($importDevice[1])
            );

            $existingDevice = Device::byUsn($did->getUsn())->first();
            
            if ($existingDevice) continue;

            $device = Device::create([
                'user_id'       => Auth::user()->id,
                'serial_number' => $importDevice[2],
                'manufacturer'  => $importDevice[0],
                'part_number'   => $importDevice[1],
                'address'       => $address,
                'usn'           => $did->getUsn(),
                'obit_did'      => $did->getDid(),
            ]);

            DeviceSaved::dispatch($device);
        }

        return redirect()->route('devices.index', $address);
    }
}
