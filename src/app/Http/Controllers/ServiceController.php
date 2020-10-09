<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Metadata;
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
     * @return Device
     */
    public function getDeviceById($device_id)
    {
        $device = Device::with('metadata','metadata.schema','obit','documents','structured_data')->find($device_id);
        if(!$device) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find device'
            ], 404);
        }

        return response()->json([
            'status' => 0,
            'device' => $device
        ], 200);
    }

    /**
     * Returns Obit object based on usn
     *
     * @return ClientObit
     */
    public function getObitByUsn(Request $request, $usn){
        $obit = ClientObit::with('device')->where([
            'usn'=>$usn
        ])->first();
        if(!$obit) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find obit'
            ], 400);
        }



        return response()->json([
            'status' => 0,
            'obit' => $obit
        ], 200);
    }

    /**
     * Returns generated USN for provided manufacturer, part_number and serial_number.
     *
     * @return array
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
        $device->save();

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
                $structured_data->structured_data_type= $s['structured_data_type'];
                $structured_data->structured_data_type_id = $s['structured_data_type_id'];
                $structured_data->data_array = $s['data_array'];
                $structured_data->data_hash = $structured_data->getHash();
                $structured_data->save();
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

        $metadata = [];
        if($device->metadata) {
            foreach($device->metadata as $m) {
                $mdata = [];
                $mdata[$m->metadata_type_id] = $m->data_txt == null ? ($m->data_int == null ? $m->data_fp : $m->data_int) : $m->data_txt;
                $metadata[] = $mdata;
            }
        }

        $structured_data = [];

        if($device->structured_data) {
            foreach($device->structured_data as $s) {
                $sdata = [
                    'structured_data_type_id'=>$s->structured_data_type_id,
                    'value'=>@json_decode($s->data_array)
                ];
                $structured_data[] = $sdata;
            }
        }

        $client_obit->obitDID = $usn['obit'];
        $client_obit->manufacturer = $device->manufacturer;
        $client_obit->owner = $device->owner;
        $client_obit->part_number = $device->part_number;

        //Temporarily Saving Unhashed Serial Number.
        //$device->serial_number should be replaced by $usn['serial_hash'];
        $client_obit->serial_number_hash = $device->serial_number;

        $client_obit->status = 0;

        $client_obit->metadata = json_encode($metadata);
        $client_obit->documents = "[]";
        $client_obit->structured_data = json_encode($structured_data);
        $client_obit->root_hash = $manager->GenerateRootHash($client_obit);

        $client_obit->save();

        return response()->json([
            'status' => 0
        ], 200);

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

        $obitApi = app()->make(ObitApi::class);
        $obit = null;
        try {
            Log::info("-- Retrieving Obit --");
            $obit = $obitApi->showObit($client_obit->obitDID);
        } catch (ApiException | Exception $e) {
            if($e->getCode() == 404) {
                $obit = null;
            } else {
                return response()->json([
                    'status' => 1,
                    'errorMessage'=>$e->getMessage()
                ], $e->getCode());
            }
        } finally {

            try {
                if($obit != null) {
                    Log::info("-- Retrieving Obit: Found --");
                    $updatedObit = new Obit([
                        'obitDid'=>$client_obit->obitDID,
                        'usn'=>$client_obit->usn,
                        'ownerDid'=>$client_obit->owner,
                        'manufacturer'=> $client_obit->manufacturer,
                        'partNumber'=>$client_obit->part_number,
                        'serialNumberHash'=>$client_obit->serial_number_hash,
                        'obitStatus'=>'FUNCTIONAL',
                        'metadata'=>$client_obit->getMetadata(),
                        'docLinks'=>$client_obit->getDocuments(),
                        'structuredData'=>$client_obit->getStructuredData(),
                        'rootHash'=>$client_obit->root_hash,
                        'modifiedAt'=>$client_obit->updated_at
                    ]);
                    $obitApi->updateObit($client_obit->obitDID,$obit);

                } else {
                    Log::info("-- Retrieving Obit: Not Found --");
                    $newObit = new NewObit([
                        'obitDid'=>$client_obit->obitDID,
                        'usn'=>$client_obit->usn,
                        'ownerDid'=>$client_obit->owner,
                        'manufacturer'=> $client_obit->manufacturer,
                        'partNumber'=>$client_obit->part_number,
                        'serialNumberHash'=>$client_obit->serial_number_hash,
                        'obitStatus'=>'FUNCTIONAL',
                        'metadata'=>$client_obit->getMetadata(),
                        'docLinks'=>$client_obit->getDocuments(),
                        'structuredData'=>$client_obit->getStructuredData(),
                        'modifiedAt'=>$client_obit->updated_at
                    ]);
                    $obitApi->createObit($newObit);
                }

            } catch (ApiException | Exception $e) {
                Log::error($e->getMessage());
                return response()->json([
                    'status' => 1,
                    'errorMessage'=>$e->getMessage()
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

        if(!$request->has('obitDID')) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Missing Obit DID'
            ], 400);
        }
        $obit_did = $request->input('obitDID');
        $client_obit = ClientObit::where([
            'obitDID'=>$obit_did
        ])->first();

        if(!$client_obit) {
            $client_obit = new ClientObit();
            $client_obit->obitDID = $obit_did;
        }
        $obitApi = app()->make(ObitApi::class);
        $obit = null;
        try {
            $obit = $obitApi->showObit($obit_did);
            $client_obit->usn = $obit->getUsn();
            $client_obit->manufacturer = $obit->getManufacturer();
            $client_obit->part_number = $obit->getPartNumber();
            $client_obit->serial_number_hash = $obit->getSerialNumberHash();
            $client_obit->owner = $obit->getOwnerDid();
            $client_obit->status = 0;
            $client_obit->documents = "[]";
            $metadata = [];
            $mdata = $obit->getMetadata();
            if($mdata && is_array($mdata)) {
                foreach($mdata as $metadataRow) {
                    $mdata = [];
                    $mdata[$metadataRow['key']] = $metadataRow['value'];
                    $metadata[] = $mdata;
                }
            }
            $client_obit->metadata = @json_encode($metadata);


            $structured_data = [];
            $sdata = $obit->getStructuredData();
            if($sdata && is_array($sdata)) {
                foreach($sdata as $structuredDataRow) {
                    $structured_data[] = [
                        'structured_data_type_id'=>$structuredDataRow['key'],
                        'value'=>@json_decode($structuredDataRow['value'], true)
                    ];
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

        $device->owner = $client_obit->owner;
        $device->part_number = $client_obit->part_number;
        $device->serial_number = $client_obit->serial_number_hash;
        $device->manufacturer = $client_obit->manufacturer;

        $device->save();

        $usn = $manager->GenerateUSN($device->manufacturer,$device->part_number, $device->serial_number);
        $device->usn = $usn['usn'];
        $device->save();

        $mdata = @json_decode($client_obit->metadata,true);
        if($mdata && is_array($mdata)) {
            foreach($mdata as $key=>$metadataValue) {
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
                if($schema->data_type == 'float' && is_float($metadataValue)) {
                    $metadata->data_fp = $metadataValue;
                } else if($schema->data_type == 'int' && is_int($metadataValue)) {
                    $metadata->data_int = $metadataValue;
                } else {
                    $metadata->data_txt = $metadataValue;
                }

                $metadata->data_hash = $metadata->getHash();
                $metadata->save();
            }
        }

        $sdata = @json_decode($client_obit->structured_data,true);
        if($sdata && is_array($sdata)) {
            foreach($sdata as $structuredDataRow) {
                $structured_data = $device->structured_data()->where([
                    'structured_data_type_id'=>$structuredDataRow['structured_data_type_id']
                ])->first();

                $schema = Schema::find($metadataValue['structured_data_type_id']);
                if(!$schema) {
                    $schema = Schema::where(['name'=>'Other'])->first();
                }

                if(!$structured_data) {
                    $structured_data = new StructuredData();
                    $structured_data->device_id = $device->id;
                    $structured_data->structured_data_type = $schema->name;
                }

                $structured_data->structured_data_type_id = $structuredDataRow['structured_data_type_id'];
                $structured_data->data_array = $structuredDataRow['value'];
                $structured_data->data_hash = $structured_data->getHash();
                $structured_data->save();
            }
        }

        return response()->json([
            'status' => 0,
            'device'=>$device
        ], 200);


    }

}


//ed92bd9cb904074ac01be4875da7818341eaa0c5afeb21623ac2927eb8ead205
