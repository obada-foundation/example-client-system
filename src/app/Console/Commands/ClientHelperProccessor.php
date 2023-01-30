<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\Device;
use App\Models\Document;

class ClientHelperProccessor extends Command 
{
    protected $signature = 'client-helper:events';

    protected $description = 'Proccess events produced by client helper';

    public function handle()
    {
        Redis::psubscribe(['*'], function ($message, $channel) {
            switch ($channel) {
                case 'device.saved':
                    $jsonDevice = json_decode($message);
                    
                    $device = Device::where('usn', $jsonDevice->usn)->first();

                    $device->obit_checksum = $jsonDevice->checksum;

                    foreach ($jsonDevice->documents as $jsonDoc) {
                        $document = $device->documents()->where('name', $jsonDoc->name)->first();
                        if (! $document) {
                            Document::create([
                                'device_id'  => $device->id,
                                'name'       => $jsonDoc->name,
                                'path'       => $jsonDoc->uri,
                                'data_hash'  => $jsonDoc->hash,
                                'encryption' => $jsonDoc->encrypted,
                            ]);

                            continue;
                        }

                        if ($document->data_hash != $jsonDoc->hash) {
                            $document->path       = $jsonDoc->uri;
                            $document->data_hash  = $jsonDoc->hash;
                            $document->encryption = $jsonDoc->encrypted;

                            $document->save();
                        }
                    }

                    $device->save();

                    break;
            }
        });
    }
}

