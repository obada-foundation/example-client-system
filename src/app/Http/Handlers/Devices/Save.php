<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use App\Events\DeviceSaved;
use Obada\Api\UtilsApi;
use Obada\ClientHelper\GenerateObitDIDRequest;
use Throwable;
use App\Models\Device;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SaveDeviceRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Save extends Handler {
    public function __invoke(SaveDeviceRequest $request, UtilsApi $utilsApi)
    {
        try {
            $user = Auth::user();

            $did = $utilsApi->generateDID(
                (new GenerateObitDIDRequest())
                ->setSerialNumber($request->get('serial_number'))
                ->setManufacturer($request->get('manufacturer'))
                ->setPartNumber($request->get('part_number'))
            );

            $existingDevice = Device::byUsn($did->getUsn())->first();

            DB::transaction(function () use (&$existingDevice, $request, $did, $user) {
                if (! $existingDevice) {
                    $existingDevice = Device::create([
                        'user_id'       => $user->id,
                        'serial_number' => $request->get('serial_number'),
                        'manufacturer'  => $request->get('manufacturer'),
                        'part_number'   => $request->get('part_number'),
                        'address'       => $request->get('address'),
                        'usn'           => $did->getUsn(),
                        'obit_did'      => $did->getDid(),
                    ]);
                }

                if ($user->id != $existingDevice->user_id) {
                    abort(401);
                }

                $existingDevice->documents()->delete();

                foreach ($request->get('documents', []) as $document) { 
                    $ipfsUrl = strpos($document['doc_path'], 'ipfs://');

                    if ($ipfsUrl !== false) {
                        Document::create([
                            'device_id'  => $existingDevice->id,
                            'name'       => $document['doc_name'],
                            'path'       => $document['doc_path'],
                            'type'       => $document['doc_type'],
                            'data_hash'  => '',
                            'encryption' => $document['doc_encryption']
                        ]);
                    } else {
                        $filePath = substr($document['doc_path'], strpos($document['doc_path'], 'documents'));
                        Document::create([
                            'device_id'  => $existingDevice->id,
                            'name'       => $document['doc_name'],
                            'path'       => $document['doc_path'],
                            'type'       => $document['doc_type'],
                            'data_hash'  => hash('sha256', Storage::get($filePath)),
                            'encryption' => $document['doc_encryption']
                        ]);
                    }
                }
            });

            DeviceSaved::dispatch($user, $existingDevice);

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
