<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use App;
use Obada\Api\UtilsApi;
use Obada\ClientHelper\GenerateObitDIDRequest;
use Throwable;
use App\Models\Device;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SaveDeviceRequest;
use Illuminate\Support\Facades\Log;

class Save extends Handler {
    public function __invoke(SaveDeviceRequest $request, UtilsApi $utilsApi)
    {
        try {
            $did = $utilsApi->generateDID(
                (new GenerateObitDIDRequest())
                ->setSerialNumber($request->get('serial_number'))
                ->setManufacturer($request->get('manufacturer'))
                ->setPartNumber($request->get('part_number'))
            );

            Log::info("USN2", ['usn' => $did->getUsn()]);

            $existingDevice = Device::byUsn($did->getUsn())->first();

            if (! $existingDevice) {
                $existingDevice = Device::create([
                    'user_id'       => Auth::user()->id,
                    'serial_number' => $request->get('serial_number'),
                    'manufacturer'  => $request->get('manufacturer'),
                    'part_number'   => $request->get('part_number'),
                    'usn'           => $did->getUsn(),
                    'obit_did'      => $did->getDid(),
                ]);
            }

            if (Auth::user()->id != $existingDevice->user_id) {
                abort(404);
            }

            foreach ($request->get('documents', []) as $document) {
                Document::create([
                    'device_id' => $existingDevice->id,
                    'name'      => $document['doc_name'],
                    'path'      => $document['doc_path'],
                    'data_hash' => ''
                ]);
            }

            return response()->json([
                'status'    => 0,
                'root_hash' => '',
                'device'    => $existingDevice
            ], 200);
        } catch (Throwable $t) {
            throw $t;
        }
    }
}