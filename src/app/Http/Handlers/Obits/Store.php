<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Obits;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Obada\Api\ObitApi;
use Obada\ClientHelper\SaveObitRequest;
use Obada\ClientHelper\DeviceDocument;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class Store extends Handler {
    public function __invoke(Request $request, ObitApi $api) {
        if (!$request->has('device_id')) {
            return response()->json([
                'status'       => 1,
                'errorMessage' => 'Unable to find device'
            ], 404);
        }
        $device = Auth::user()
            ->devices()
            ->byUsn($request->get('device_id'))
            ->first();

        if (! $device) {
            return response()->json([
                'status'       => 1,
                'errorMessage' => 'Unable to find device'
            ], 404);
        }

        try {
            $tokenCreator = app(Token::class);

            $token = $tokenCreator->create(Auth::user());
            
            $api->getConfig()->setAccessToken($token);

            $documents = $device->documents
                ->map(function (Document $document) {                    
                    $filePath = substr($document->path, strpos($document->path, 'documents'));
                    
                    $base64File = base64_encode(Storage::disk('s3')->get($filePath));

                    return (new DeviceDocument)
                        ->setName($document->name)
                        ->setDocumentFile($base64File);
                })
                ->toArray();

            $clientHelperObit = $api->save(
                (new SaveObitRequest())
                    ->setSerialNumber($device->serial_number)
                    ->setManufacturer($device->manufacturer)
                    ->setPartNumber($device->part_number)
                    ->setDocuments($documents)
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