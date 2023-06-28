<?php

namespace App\Listeners;

use App\Events\DeviceImported;
use Obada\Api\ObitApi;
use Obada\ClientHelper\SaveObitRequest;
use App\ClientHelper\Token;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Obada\ClientHelper\DeviceDocument;

class ClientHelperImport
{
    protected Token $tokenCreator;

    protected ObitApi $api;

    public function __construct(ObitApi $api, Token $tokenCreator) 
    {
        $this->api = $api;
        $this->tokenCreator = $tokenCreator;
    }

    public function handle(DeviceImported $event)
    {
        $token = $this->tokenCreator->create($event->user);

        $this->api->getConfig()->setAccessToken($token);

        $documents = $event->device
            ->documents()
            ->get()
            ->map(function (Document $document) {                    
                $ipfsUrl = strpos($document->path, 'ipfs://');
                $base64File = '';
                if ($ipfsUrl !== false) {
                    $cidParts = explode('://', $document->path);
                    $cid      = $cidParts[1];
            
                    $base64File = base64_encode(file_get_contents(config('ipfs.gateway') . $cid, true));
                } else {
                    $filePath = substr($document->path, strpos($document->path, 'documents'));
                    $base64File = base64_encode(Storage::get($filePath));
                }
  
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