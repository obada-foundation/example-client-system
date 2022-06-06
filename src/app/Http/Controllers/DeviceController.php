<?php

namespace App\Http\Controllers;

use App\Facades\ObadaClient;
use App\Http\Requests\UsnRequest;
use App\Models\Device;
use App\Models\Documents;
use App\Models\Metadata;
use App\Models\Schema;
use App\Models\StructuredData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Obada\Api\HelperApi;
use Obada\ClientHelper\ObitDid;

class DeviceController extends Controller
{
    public function __construct(protected HelperApi $helperApi)
    {
    }

    /**
     * Saves a Device based on input.  If device_id is provided, the device will be updated, else a new row is created.
     *
     * @return JsonResponse
     */
    public function saveDevice(Request $request)
    {
        $input = $request->input();

        try {
            $result = $this->helperApi->generateObitDef(
                $input['manufacturer'],
                $input['part_number'],
                $input['serial_number']
            );

            $usn = $result['obit'];
        } catch (\Exception $e) {
            return response()->json([
                'status' => 1,
                'errorMessage' => $e->getMessage()
            ], 400);
        }

        if ($request->input('device_id') != 0) {
            $device = Device::with('metadata', 'documents', 'structured_data')->find($request->input('device_id'));
            if (!$device) {
                return response()->json([
                    'status' => 1,
                    'errorMessage' => 'Unable to find device'
                ], 400);
            }
        } else {
            Log::info("USN2", ['usn' => $usn['usn']]);

            $existingDevice = Device::where([
                'usn' => $usn['usn']
            ])->first();

            if ($existingDevice) {
                return response()->json([
                    'status' => 1,
                    'errorMessage' => 'Device With This USN Already Exists'
                ], 400);
            }

            $device = new Device();
        }

        $device->manufacturer = $input['manufacturer'];
        $device->part_number = $input['part_number'];
        $device->serial_number = $input['serial_number'];
        $device->owner = $input['owner'];
        $device->status = $input['status'];

        $device->usn = $usn['usn'];
        $device->obit_did = $usn['obitDid'];
        $device->save();
        if (isset($input['metadata']) && $input['metadata']) {
            foreach ($input['metadata'] as $m) {
                if (isset($m['id'])) {
                    $metadata = Metadata::find($m['id']);
                    if (!$metadata) {
                        $metadata = new Metadata();
                    }
                } else {
                    $metadata = new Metadata();
                }
                $metadata->device_id = $device->id;
                $metadata->metadata_type_id = $m['metadata_type_id'];
                if (isset($m['data_fp'])) {
                    $metadata->data_fp = $m['data_fp'];
                }

                if (isset($m['data_txt'])) {
                    $metadata->data_txt = $m['data_txt'];
                }

                if (isset($m['data_int'])) {
                    $metadata->data_int = $m['data_int'];
                }
                $metadata->data_hash = '';
                $metadata->save();
            }
        }

        if (isset($input['structured_data']) && $input['structured_data']) {
            foreach ($input['structured_data'] as $s) {
                if (isset($s['id'])) {
                    $structured_data = StructuredData::find($s['id']);
                    if (!$structured_data) {
                        $structured_data = new StructuredData();
                    }
                } else {
                    $structured_data = new StructuredData();
                }
                $structured_data->device_id = $device->id;
                $structured_data->structured_data_type_id = $s['structured_data_type_id'];
                $structured_data->data_array = $s['data_array'];
                $structured_data->data_hash = $structured_data->getHash();
                $structured_data->save();
            }
        }

        if (isset($input['documents']) && $input['documents']) {
            foreach ($input['documents'] as $d) {
                if (isset($d['id'])) {
                    $document = Documents::find($d['id']);
                    if (!$document) {
                        $document = new Documents();
                    }
                } else {
                    $document = new Documents();
                }
                $document->device_id = $device->id;
                $document->doc_type_id = $d['doc_type_id'];
                $document->doc_path = $d['doc_path'];
                $document->data_hash = $document->getHash();
                $document->save();
            }
        }

        if (isset($input['structured_data_to_remove']) && $input['structured_data_to_remove']) {
            foreach ($input['structured_data_to_remove'] as $s) {
                $structured_data = StructuredData::find($s);
                if ($structured_data) {
                    $structured_data->delete();
                }
            }
        }

        if (isset($input['metadata_to_remove']) && $input['metadata_to_remove']) {
            foreach ($input['metadata_to_remove'] as $m) {
                $metadata = Metadata::find($m);
                if ($metadata) {
                    $metadata->delete();
                }
            }
        }

        if (isset($input['documents_to_remove']) && $input['documents_to_remove']) {
            foreach ($input['documents_to_remove'] as $d) {
                $document = Documents::find($d);
                if ($document) {
                    $document->delete();
                }
            }
        }

        try {
            Log::info('payload', ['payload' => $device->getLocalObit()]);
            $result = $this->helperApi->generateRootHash($device->getLocalObit());

            Log::info('root hash', ['rh' => $result['rootHash']]);

            return response()->json([
                'status' => 0,
                'root_hash' => $result['rootHash'],
                'device' => $device
            ], 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Error Generating Device Root Hash'
            ], 400);
        }
    }


    /**
     * Returns generated USN for provided manufacturer, part_number and serial_number.
     *
     * @return JsonResponse
     */
    public function generateUsn(UsnRequest $request)
    {
        $input = $request->input();

        try {
            $result = ObadaClient::generateObitDef(
                $input['manufacturer'],
                $input['part_number'],
                $input['serial_number']
            );

            return response()->json([
                'status' => 0,
                'usn'    => $result['obit']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 1,
                'errorMessage' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Returns Device object based on device_id
     */
    public function getDevice($obit_did): \App\Models\Device|\Illuminate\Http\JsonResponse
    {
        $device = Device::with('metadata', 'metadata.schema', 'documents', 'structured_data')->where([
            'obit_did' => $obit_did
        ])->first();
        if (!$device) {
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Unable to find device'
            ], 404);
        }
        try {
            $result = $this->helperApi->generateRootHash($device->getLocalObit());

            return response()->json([
                'status' => 0,
                'device' => $device,
                'root_hash' => $result['rootHash']
            ], 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Error Generating Device Root Hash'
            ], 400);
        }
    }

    /**
     * Returns Device object based on device_id
     */
    public function getDeviceWithId($id): \App\Models\Device|\Illuminate\Http\JsonResponse
    {
        $device = Device::with('metadata', 'metadata.schema', 'documents', 'structured_data')->find($id);
        if (!$device) {
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Unable to find device'
            ], 404);
        }
        try {
            $result = $this->helperApi->generateRootHash($device->getLocalObit());
            return response()->json([
                'status' => 0,
                'device' => $device,
                'root_hash' => $result['rootHash']
            ], 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Error Generating Device Root Hash'
            ], 400);
        }
    }

    /**
     * Returns Obit object based on usn
     */
    public function getObit(Request $request, $obit_did): \ClientObit|\Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->helperApi->getClientObit($obit_did);

            return response()->json([
                'status' => 0,
                'obit' => $result['obit']
            ], 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Error Getting Client Obit'
            ], 400);
        }
    }

    /**
     * Creates a Client Obit from the device provided.  If a client obit already exists, it is updated.
     *
     * @return JsonResponse
     */
    public function createObit(Request $request)
    {
        if (!$request->has('device_id')) {
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Unable to find device'
            ], 404);
        }

        $device = Device::find($request->input('device_id'));
        if (!$device) {
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Unable to find device'
            ], 404);
        }

        try {
            $this->helperApi->saveClientObit($device->getLocalObit());

            return response()->json([
                'status' => 0
            ], 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Log::info($e->getTraceAsString());
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Error Saving Client Obit',
                'device' => $device,
                'local' => $device->getLocalObit()
            ], 400);
        }
    }

    /**
     * Returns Obit object based on usn
     *
     * @return JsonResponse
     */
    public function getBlockchainObit(Request $request, $obit_did)
    {
        try {
            $result = $this->helperApi->fetchObitFromChain($obit_did);

            return response()->json([
                'status' => 0,
                'obit' => $result['blockchainObit']
            ], 200);
        } catch (\Exception) {
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Error Getting Blockchain Obit'
            ], 400);
        }
    }

    /**
     * Syncs a Client Obit with the Blockchain using the Obada PHP Client Library.
     *
     * @return JsonResponse
     */
    public function uploadObit(Request $request)
    {
        //Integrate API

        if (!$request->has('obit_did')) {
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Unable to find device'
            ], 400);
        }

        try {
            ObadaClient::uploadObit(new ObitDid(['obitDid' => $request->input('obit_did')]));
            return response()->json([
                'status' => 0
            ], 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Error Uploading Client Obit'
            ], 400);
        }
    }

    /**
     * phpcs:ignore
     * Creates or Updates the Client Obit with the data retrieved from the Blockchain using the Obada PHP Client Library.
     * Takes the Obit_DID as input.
     *
     * @return JsonResponse
     */
    public function downloadObit(Request $request)
    {

        if (!$request->has('obit_did')) {
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Unable to find device'
            ], 400);
        }

        try {
            $result = $this->helperApi->fetchObitFromChain($request->input('obit_did'));

            return response()->json([
                'status' => 0,
                'obit' => $result['obit']
            ], 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Error Uploading Client Obit'
            ], 400);
        }
    }


    public function uploadDocument(Request $request)
    {
        $data = $request->all();
        $file = $data['file'];
        $file_type = $data['file_type'];
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        $s3 = App::make('aws')->createClient('s3');
        $bucket = env('AWS_BUCKET');
        $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $data['folder'] . '/' . $filename,
            'Body' => file_get_contents($file),
            'ContentType' => $file_type,
            'ACL' => 'public-read'
        ]);

        return response()->json([
            'status' => 0,
            'url' => $result['ObjectURL']
        ], 200);
    }

    /**
     * Creates or Updates the Device using the Client Obit.
     *
     * @return JsonResponse
     */
    public function mapObitToDevice(Request $request)
    {

        if (!$request->has('obit_did')) {
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Unable to find obit'
            ], 400);
        }

        try {
            $result = $this->helperApi->getClientObit($request->input('obit_did'));
            $client_obit = $result['obit'];
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => 1,
                'errorMessage' => 'Error Getting Client Obit'
            ], 400);
        }

        $device = Device::where([
            'obit_did' => $request->input('obit_did')
        ])->first();

        if (!$device) {
            $device = new Device();
        }
        $device->usn = $client_obit['usn'];
        $device->obit_did = $client_obit['obitDid'];
        $device->owner = $client_obit['ownerDid'];
        $device->part_number = $client_obit['partNumber'];
        $device->serial_number = $client_obit['serialNumberHash'];
        $device->manufacturer = $client_obit['manufacturer'];

        $device->save();

        if ($client_obit['metadata'] && is_array($client_obit['metadata'])) {
            foreach ($client_obit['metadata'] as $key => $value) {
                $metadata = $device->metadata()->where([
                    'metadata_type_id' => $key
                ])->first();
                $schema = Schema::where([
                    'name' => $key
                ])->first();
                if (!$schema) {
                    $schema = Schema::where(['name' => 'Other'])->first();
                }

                if (!$metadata) {
                    $metadata = new Metadata();
                    $metadata->device_id = $device->id;
                }

                $metadata->metadata_type_id = $key;

                if ($schema->data_type == 'float' && is_numeric($value)) {
                    $metadata->data_fp = $value;
                    $metadata->data_int = null;
                    $metadata->data_txt = null;
                } elseif ($schema->data_type == 'int' && is_int($value)) {
                    $metadata->data_fp = null;
                    $metadata->data_int = $value;
                    $metadata->data_txt = null;
                } else {
                    $metadata->data_fp = null;
                    $metadata->data_int = null;
                    $metadata->data_txt = $value;
                }

                $metadata->data_hash = '';
                $metadata->save();
            }
        }

        if ($client_obit['structuredData'] && is_array($client_obit['structuredData'])) {
            foreach ($client_obit['structuredData'] as $key => $value) {
                $structured_data = $device->structuredData()
                    ->where('structured_data_type_id', $key)
                    ->first();

                $schema = Schema::where('name', $key)->first();

                if (!$schema) {
                    $schema = Schema::where(['name' => 'Other'])->first();
                }

                if (!$structured_data) {
                    $structured_data = new StructuredData();
                    $structured_data->device_id = $device->id;
                }

                $structured_data->structured_data_type_id = $key;
                $structured_data->data_array = $value;
                $structured_data->data_hash = $structured_data->getHash();
                $structured_data->save();
            }
        }

        if ($client_obit['documents'] && is_array($client_obit['documents'])) {
            foreach ($client_obit['documents'] as $key => $value) {
                $document = $device->documents()->where([
                    'doc_type_id' => $key
                ])->first();

                $schema = Schema::where([
                    'name' => $key
                ])->first();

                if (!$schema) {
                    $schema = Schema::where(['name' => 'Other'])->first();
                }

                if (!$document) {
                    $document = new Documents();
                    $document->device_id = $device->id;
                }

                $document->doc_type_id = $key;
                $document->doc_path = $value;
                $document->data_hash = $document->getHash();
                $document->save();
            }
        }

        return response()->json([
            'status' => 0,
            'device' => $device
        ], 200);
    }
}
