<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Metadata;
use App\Models\Documents;
use App\Models\StructuredData;
use App\Models\ClientObit;
use App\Models\Schema;
use App\ObitManager\ObitManager;
use App\Http\Requests\UsnRequest;
use Obada\Api\ObitApi;
use Obada\Entities\NewObit;
use Obada\Entities\MetaDataRecord;
use Obada\Entities\Obit;
use Obada\ApiException;
use Log;

class ServiceController extends Controller
{
    /**
     * Returns Device object based on device_id
     *
     * @return Device | JsonResponse
     */
    public function getDeviceById(ObitManager $manager, $device_id)
    {
        $device = Device::with('metadata','metadata.schema','obit','documents','structured_data')->find($device_id);
        if(!$device) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find device'
            ], 404);
        }

        $device->root_hash = $manager->GenerateDeviceRootHash($device);

        return response()->json([
            'status' => 0,
            'device' => $device
        ], 200);
    }

    /**
     * Returns Obit object based on usn
     *
     * @return ClientObit | JsonResponse
     */
    public function getObitByUsn(Request $request, ObitManager $manager, $usn){
        $obit = ClientObit::with('device')->where([
            'usn'=>$usn
        ])->first();


        if(!$obit) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find obit'
            ], 400);
        }

        $root_hash = $manager->GenerateRootHash($obit);

        return response()->json([
            'status' => 0,
            'obit' => $obit,
            'root_hash'=>$root_hash
        ], 200);
    }

    public function getObitHistoryByUsn(Request $request, ObitManager $manager, $usn){
        $obit = ClientObit::with('device')->where([
            'usn'=>$usn
        ])->first();


        if(!$obit) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find obit'
            ], 400);
        }
        $obitApi = new ObitApi();
        $history = $obitApi->showObitHistory($obit->obit_did);
        dd($history);
        return response()->json([
            'status' => 0,
            'obit_history' => $history
        ], 200);
    }

    /**
     * Returns generated USN for provided manufacturer, part_number and serial_number.
     *
     * @return Array | JsonResponse
     */
    public function generateUsn(UsnRequest $request, ObitManager $manager){
        $input = $request->input();
        $usn_data = $manager->GenerateUSN($input['manufacturer'],$input['part_number'],$input['serial_number']);
        return response()->json([
            'status' => 0,
            'usn' => $usn_data
        ], 200);
    }

    /**
     * Saves a Device based on input.  If device_id is provided, the device will be updated, else a new row is created.
     *
     * @return Device
     */
    public function saveDevice(Request $request, ObitManager $manager)
    {
        if($request->input('device_id') != 0) {
            $device = Device::with('metadata','documents','structured_data')->find($request->input('device_id'));
        } else {
            $device = new Device();
        }

        $input = $request->input();
        $device->manufacturer = $input['manufacturer'];
        $device->part_number = $input['part_number'];
        $device->serial_number = $input['serial_number'];
        $device->owner = $input['owner'];
        $device->status = $input['status'];

        $usn = $manager->GenerateUSN($device->manufacturer,$device->part_number, $device->serial_number);
        $device->usn = $usn['usn'];
        $device->save();

        if(isset($input['metadata']) && $input['metadata']) {
            foreach($input['metadata'] as $m) {
                if(isset($m['id'])) {
                    $metadata = Metadata::find($m['id']);
                    if(!$metadata) {
                        $metadata = new Metadata();
                    }
                } else {
                    $metadata = new Metadata();
                }
                $metadata->device_id = $device->id;
                $metadata->metadata_type_id = $m['metadata_type_id'];
                if(isset($m['data_fp']))
                    $metadata->data_fp = $m['data_fp'];

                if(isset($m['data_txt']))
                    $metadata->data_txt = $m['data_txt'];

                if(isset($m['data_int']))
                    $metadata->data_int = $m['data_int'];
                $metadata->data_hash = $metadata->getHash();
                $metadata->save();
            }
        }

        if(isset($input['structured_data']) && $input['structured_data']) {
            foreach($input['structured_data'] as $s) {
                if(isset($s['id'])) {
                    $structured_data = StructuredData::find($s['id']);
                    if(!$structured_data) {
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

        if(isset($input['documents']) && $input['documents']) {
            foreach($input['documents'] as $d) {
                if(isset($d['id'])) {
                    $document = Documents::find($d['id']);
                    if(!$document) {
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

        if(isset($input['structured_data_to_remove']) && $input['structured_data_to_remove']) {
            foreach($input['structured_data_to_remove'] as $s) {
                $structured_data = StructuredData::find($s);
                if($structured_data){
                    $structured_data->delete();
                }
            }
        }

        if(isset($input['metadata_to_remove']) && $input['metadata_to_remove']) {
            foreach($input['metadata_to_remove'] as $m) {
                $metadata = Metadata::find($m);
                if($metadata){
                    $metadata->delete();
                }
            }
        }

        if(isset($input['documents_to_remove']) && $input['documents_to_remove']) {
            foreach($input['documents_to_remove'] as $d) {
                $document = Documents::find($d);
                if($document){
                    $document->delete();
                }
            }
        }

        return response()->json([
            'status' => 0,
            'device' => $device
        ], 200);
    }

    /**
     * Creates a Client Obit from the device provided.  If a client obit already exists, it is updated.
     *
     * @return ClientObit
     */
    public function createObit(Request $request, ObitManager $manager)
    {
        if(!$request->has('device_id')) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find device'
            ], 400);
        }

        $device = Device::find($request->input('device_id'));
        if(!$device) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find device'
            ], 400);
        }

        $usn = $manager->GenerateUSN($device->manufacturer,$device->part_number, $device->serial_number);
        $client_obit = ClientObit::where([
            'usn'=>$usn['usn']
        ])->first();

        if(!$client_obit) {
            $client_obit = new ClientObit();
            $client_obit->usn = $usn['usn'];
        }

        $metadata = $device->getMetadataArray();
        $structured_data = $device->getStructuredDataArray();
        $documents = $device->getDocumentsArray();


        $client_obit->obit_did = $usn['obit'];
        $client_obit->manufacturer = $device->manufacturer;
        $client_obit->owner_did = $device->owner;
        $client_obit->obd_did = '';
        $client_obit->part_number = $device->part_number;

        //Temporarily Saving Unhashed Serial Number.
        //$device->serial_number should be replaced by $usn['serial_hash'];
        $client_obit->serial_number_hash = $device->serial_number;

        $client_obit->obit_status = $device->status;

        $client_obit->metadata = json_encode($metadata);
        $client_obit->documents = json_encode($documents);
        $client_obit->structured_data = json_encode($structured_data);
        $client_obit->root_hash = $manager->GenerateRootHash($client_obit);
        $client_obit->save();

        return response()->json([
            'status' => 0
        ], 200);

    }

    public function testObit(Request $request, ObitManager $manager)
    {
        $id = $request->input('id');
        $client_obit = ClientObit::find($id);
        $mappedObit = $manager->GetMappedObit($client_obit);
        dd($mappedObit);

        $obitApi = new ObitApi();
        $obit = $obitApi->showObit($client_obit->obit_did);

        $docs = $obit->getDocLinks();
        dd($docs);
    }

    /**
     * Syncs a Client Obit with the Blockchain using the Obada PHP Client Library.
     *
     * @return void
     */
    public function syncObit(Request $request, ObitManager $manager){
        //Integrate API

        if(!$request->has('usn')) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find device'
            ], 400);
        }

        $client_obit = ClientObit::where([
            'usn'=>$request->input('usn')
        ])->first();

        if(!$client_obit) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find Obit'
            ], 400);
        }

        $obitApi = new ObitApi();
        $obit = null;
        try {
            Log::info("-- Retrieving Obit --");
            $obit = $obitApi->showObit($client_obit->obit_did);
        } catch (ApiException | Exception $e) {
            if($e->getCode() == 404) {
                Log::info("-- Obit Not Found --");
                $obit = null;
            } else {
                return response()->json([
                    'status' => 1,
                    'errorMessage'=>$e->getMessage()
                ], $e->getCode());
            }
        } finally {
            $updatedObit = $manager->GetMappedObit($client_obit);
            try {
                if($obit != null) {
                    $obitApi->updateObit($client_obit->obit_did,$updatedObit);
                } else {
                    $obitApi->createObit($updatedObit);
                }

            } catch (ApiException | Exception $e) {
                Log::error($e->getMessage());
                return response()->json([
                    'status' => 1,
                    'errorMessage'=>$e->getMessage(),
                    'payload'=>$updatedObit
                ], $e->getCode() ?? 500);
            }

            return response()->json([
                'status' => 0
            ], 200);

        }

    }

    /**
     * Creates or Updates the Client Obit with the data retrieved from the Blockchain using the Obada PHP Client Library.
     * Takes the Obit_DID as input.
     *
     * @return ClientObit
     */
    public function retrieveObit(Request $request){

        if(!$request->has('obit_did')) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Missing Obit DID'
            ], 400);
        }
        $obit_did = $request->input('obit_did');
        $client_obit = ClientObit::where([
            'obit_did'=>$obit_did
        ])->first();

        if(!$client_obit) {
            $client_obit = new ClientObit();
            $client_obit->obit_did = $obit_did;
        }
        $obitApi = app()->make(ObitApi::class);
        $obit = null;
        try {
            $obit = $obitApi->showObit($obit_did);
            $client_obit->usn = $obit->getUsn();
            $client_obit->manufacturer = $obit->getManufacturer();
            $client_obit->part_number = $obit->getPartNumber();
            $client_obit->serial_number_hash = $obit->getSerialNumberHash();
            $client_obit->owner_did = $obit->getOwnerDid();
            $client_obit->obit_status = $obit->getObitStatus();
            $client_obit->obd_did = '';

            $documents = [];
            $docs = $obit->getDocLinks();
            if($docs && is_array($docs)) {
                foreach($docs as $documentLink) {
                    $documents[$documentLink['name']] = $documentLink['hashlink'];
                }
            }
            $client_obit->documents = @json_encode($documents);

            $metadata = [];
            $mdata = $obit->getMetadata();
            if($mdata && is_array($mdata)) {
                foreach($mdata as $metadataRow) {
                    $metadata[$metadataRow['key']] = $metadataRow['value'];
                }
            }
            $client_obit->metadata = @json_encode($metadata);


            $structured_data = [];
            $sdata = $obit->getStructuredData();
            if($sdata && is_array($sdata)) {
                foreach($sdata as $structuredDataRow) {
                    $structured_data[$structuredDataRow['key']] = @json_decode($structuredDataRow['value'], true);
                }
            }
            $client_obit->structured_data = @json_encode($structured_data);
            $client_obit->root_hash = $obit->getRootHash();
            $client_obit->save();

        } catch (ApiException | Exception $e) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>$e->getMessage()
            ], $e->getCode());
        }

        return response()->json([
            'status' => 0,
            'client_obit'=>$client_obit
        ], 200);

    }

    /**
     * Creates or Updates the Device using the Client Obit.
     *
     * @return Device
     */
    public function mapObitToDevice(Request $request, ObitManager $manager){
        if(!$request->has('usn')) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find obit'
            ], 400);
        }

        $client_obit = ClientObit::where([
            'usn'=>$request->input('usn')
        ])->first();

        if(!$client_obit) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find obit'
            ], 400);
        }

        $device = Device::where([
            'usn'=>$client_obit->usn
        ])->first();

        if(!$device) {
            $device = new Device();
        }
        $device->usn = $client_obit->usn;
        $device->owner = $client_obit->owner_did;
        $device->part_number = $client_obit->part_number;
        $device->serial_number = $client_obit->serial_number_hash;
        $device->manufacturer = $client_obit->manufacturer;

        $device->save();

        $mdata = @json_decode($client_obit->metadata,true);
        if($mdata && is_array($mdata)) {
            foreach($mdata as $key=>$value) {

                $metadata = $device->metadata()->where([
                    'metadata_type_id'=>$key
                ])->first();
                $schema = Schema::where([
                    'name'=>$key
                ])->first();
                if(!$schema) {
                    $schema = Schema::where(['name'=>'Other'])->first();
                }

                if(!$metadata) {
                    $metadata = new Metadata();
                    $metadata->device_id = $device->id;
                }

                $metadata->metadata_type_id = $key;

                if($schema->data_type == 'float' && is_numeric($value)) {
                    $metadata->data_fp = $value;
                    $metadata->data_int = null;
                    $metadata->data_txt = null;
                } else if($schema->data_type == 'int' && is_int($value)) {
                    $metadata->data_fp = null;
                    $metadata->data_int = $value;
                    $metadata->data_txt = null;
                } else {
                    $metadata->data_fp = null;
                    $metadata->data_int = null;
                    $metadata->data_txt = $value;
                }

                $metadata->data_hash = $metadata->getHash();
                $metadata->save();
            }
        }

        $sdata = @json_decode($client_obit->structured_data,true);
        if($sdata && is_array($sdata)) {
            foreach($sdata as $key => $value) {
                $structured_data = $device->structured_data()->where([
                    'structured_data_type_id'=>$key
                ])->first();

                $schema = Schema::where([
                    'name'=>$key
                ])->first();
                if(!$schema) {
                    $schema = Schema::where(['name'=>'Other'])->first();
                }

                if(!$structured_data) {
                    $structured_data = new StructuredData();
                    $structured_data->device_id = $device->id;
                }

                $structured_data->structured_data_type_id = $key;
                $structured_data->data_array = $value;
                $structured_data->data_hash = $structured_data->getHash();
                $structured_data->save();
            }
        }

        $docs = @json_decode($client_obit->documents,true);
        if($docs && is_array($docs)) {
            foreach($docs as $key => $value) {
                $document = $device->documents()->where([
                    'doc_type_id'=>$key
                ])->first();

                $schema = Schema::where([
                    'name'=>$key
                ])->first();

                if(!$schema) {
                    $schema = Schema::where(['name'=>'Other'])->first();
                }

                if(!$document) {
                    $document = new Document();
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
            'device'=>$device
        ], 200);


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
            'url'=>$result['ObjectURL']
        ], 200);

    }
}


//ed92bd9cb904074ac01be4875da7818341eaa0c5afeb21623ac2927eb8ead205
