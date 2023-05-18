<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\User;
use App\Models\Device;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Exception;

class ClientHelperProccessor extends Command 
{
    protected $signature = 'client-helper:events';

    protected $description = 'Proccess events produced by client helper';

    public function handle()
    {
        Redis::psubscribe(['*'], function ($message, $channel) {
            switch ($channel) {
                case 'device.saved':
                    $json   = json_decode($message);
                    $userId = (int) $json->profile_id; 

                    if (! $userId) {
                        throw new Exception('Received an empty profile id');
                    }
                    
                    $device = Device::where('usn', $json->device->usn)
                        ->where('user_id', $userId)
                        ->first();

                    if (! $device) {
                        $this->createDevice($userId, $json->device);
                    } else {
                        $this->updateDevice($device, $json->device);
                    }

                    $this->info(sprintf("Obit with USN %s was imported", $json->device->usn));

                    break;
            }
        });
    }

    public function createDevice($userId, object $jsonDevice) 
    {
        $user = User::findOrFail($userId);

        $documents = $jsonDevice->documents;

        $assetIdentifierDoc = collect($documents)
            ->filter(fn ($document) => $document->name === 'physicalAssetIdentifiers')
            ->first();

        if (! $assetIdentifierDoc) {
            throw new Exception('Missing physical identifier');
        }

        $cidParts = explode('://', $assetIdentifierDoc->uri);
        $cid      = $cidParts[1];

        $assetIdentifierDocContent = json_decode(
            file_get_contents(config('ipfs.gateway') . $cid), 
            true
        );

        DB::transaction(function () use ($user, $jsonDevice, $assetIdentifierDocContent, $documents) {
            $device = Device::create([
                'user_id'       => $user->id,
                'usn'           => $jsonDevice->usn,
                'manufacturer'  => $assetIdentifierDocContent['manufacturer'],
                'part_number'   => $assetIdentifierDocContent['part_number'],
                'serial_number' => $assetIdentifierDocContent['serial_number'],
                'obit_did'      => $jsonDevice->did,
                'obit_checksum' => $jsonDevice->checksum,
                'address'       => $jsonDevice->address,
            ]);

            foreach ($documents as $document) {
                Document::create([
                    'device_id'  => $device->id,
                    'name'       => $document->name,
                    'data_hash'  => $document->hash,
                    'path'       => $document->uri,
                    'type'       => $document->type,
                    'encryption' => $document->encrypted,
                ]);
            }
        });
    }

    public function updateDevice(Device $device, object $jsonDevice) 
    {
        $device->obit_checksum = $jsonDevice->checksum;

        $docs = collect($jsonDevice->documents)
            ->map(function ($jsonDoc) use ($device) {
                $localDoc = $device->documents()
                    ->where('name', $jsonDoc->name)
                    ->first();

                if (! $localDoc) {
                    return $jsonDoc;
                }

                return $jsonDoc;
            });

        $device->documents()->delete();

        foreach ($docs as $jsonDoc) {
            Document::create([
                'device_id'  => $device->id,
                'name'       => $jsonDoc->name,
                'path'       => $jsonDoc->uri,
                'type'       => $jsonDoc->type,
                'data_hash'  => $jsonDoc->hash,
                'encryption' => $jsonDoc->encrypted,
            ]); 
        }

        $device->save();
    }
}

