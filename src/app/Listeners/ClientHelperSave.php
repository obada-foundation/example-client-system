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
    protected Token $tokenCreator;

    protected ObitApi $api;

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
                $base64File = base64_encode(Storage::get($filePath));
  
                return (new DeviceDocument)
                    ->setName($document->name)
                    ->setDocumentFile($base64File)
                    ->setShouldEncrypt($document->encryption);
            })
            ->toArray();

        $clientHelperObit = $this->api->save(
            (new SaveObitRequest())
                ->setSerialNumber($event->device->serial_number)
                ->setManufacturer($event->device->manufacturer)
                ->setPartNumber($event->device->part_number)
                ->setAddress($event->device->address)
                ->setDocuments($documents)
        );

        $event->device->obit_checksum = $clientHelperObit->getChecksum();
        $event->device->save();
    }
}