<?php

namespace App\Listeners;

use App\Events\DeviceSaved;
use Obada\Api\ObitApi;
use Obada\ClientHelper\SaveObitRequest;
use App\ClientHelper\Token;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Obada\ClientHelper\DeviceDocument;

class ClientHelperSave
{
    public function __construct(ObitApi $api, Token $tokenCreator) 
    {
        $this->api = $api;
        $this->tokenCreator = $tokenCreator;
    }

    public function handle(DeviceSaved $event)
    {
        $token = $this->tokenCreator->create(Auth::user());

        $this->api->getConfig()->setAccessToken($token);

        $documents = $event->device
            ->documents()
            ->get()
            ->map(function (Document $document) {                    
                $filePath = substr($document->path, strpos($document->path, 'documents'));
                
                $base64File = base64_encode(Storage::disk('s3')->get($filePath));

                return (new DeviceDocument)
                    ->setName($document->name)
                    ->setDocumentFile($base64File);
            })
            ->toArray();

        $clientHelperObit = $this->api->save(
            (new SaveObitRequest())
                ->setSerialNumber($event->device->serial_number)
                ->setManufacturer($event->device->manufacturer)
                ->setPartNumber($event->device->part_number)
                ->setDocuments($documents)
        );

        $event->device->obit_checksum = $clientHelperObit->getChecksum();
        $event->device->save();
    }
}