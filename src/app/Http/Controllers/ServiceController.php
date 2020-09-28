<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Metadata;
use App\Models\StructuredData;
use App\Models\ClientObit;
use App\ObitManager\ObitManager;
use App\Http\Requests\UsnRequest;
use Obada\Api\ObitApi;
use Obada\Entities\NewObit;
use Obada\Entities\Obit;

class ServiceController extends Controller
{
    public function getDeviceById($device_id)
    {
        $device = Device::with('metadata','documents','structured_data')->find($device_id);
        if(!$device) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find device'
            ], 400);
        }

        return response()->json([
            'status' => 0,
            'device' => $device
        ], 200);
    }

    public function getObitByUsn(Request $request, $usn){
        $obit = ClientObit::where([
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

    public function generateUsn(UsnRequest $request, ObitManager $manager){
        $input = $request->input();
        $usn_data = $manager->GenerateUSN($input['manufacturer'],$input['part_number'],$input['serial_number']);
        return response()->json([
            'status' => 0,
            'usn' => $usn_data
        ], 200);
    }

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
        $device->synced_with_client_obits = 0;
        $device->synced_with_obada = 0;
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
                $metadata->metadata_type = $m['metadata_type'];
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

        if($device->synced_with_client_obits != 0) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Device is already in sync'
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
                $mdata['metadata_type'] = $m->metadata_type;
                $mdata['metadata_type_id'] = $m->metadata_type_id;
                $mdata['data_type'] = $m->data_txt == null ? ($m->data_int == null ? 'float' : 'integer') : 'text';
                $mdata['value'] = $m->data_txt == null ? ($m->data_int == null ? $m->data_fp : $m->data_int) : $m->data_txt;
                $metadata[] = $mdata;
            }
        }

        $structured_data = [];

        if($device->structured_data) {
            foreach($device->structured_data as $s) {
                $sdata = [];
                $sdata = json_decode($s->data_array);
                $structured_data[] = $sdata;
            }
        }

        $client_obit->obitDID = $usn['obit'];
        $client_obit->manufacturer = $device->manufacturer;
        $client_obit->owner = $device->owner;
        $client_obit->part_number = $device->part_number;
        $client_obit->serial_number_hash = $usn['serial_hash'];
        $client_obit->status = 0;

        $client_obit->metadata = json_encode($metadata);
        $client_obit->documents = "[]";
        $client_obit->structured_data = json_encode($structured_data);
        $client_obit->root_hash = $manager->GenerateRootHash($client_obit);

        $client_obit->save();

        $device->synced_with_client_obits = 1;
        $device->save();
        return response()->json([
            'status' => 0
        ], 200);

    }

    public function syncDevice(Request $request, ObitManager $manager){
        //Integrate API

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

        if($device->synced_with_obada != 0) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Obit is already in sync'
            ], 400);
        }

        $usn = $manager->GenerateUSN($device->manufacturer,$device->part_number, $device->serial_number);
        $client_obit = ClientObit::where([
            'usn'=>$usn['usn']
        ])->first();

        if(!$client_obit) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>'Unable to find Obit'
            ], 400);
        }

        $obitApi = app()->make(ObitApi::class);
        $obit = new NewObit([
            'obitDid'=>$client_obit->obitDID,
            'usn'=>$client_obit->usn,
            'ownerDid'=>$client_obit->owner,
            'manufacturer'=> $client_obit->manufacturer,
            'partNumber'=>$client_obit->part_number,
            'serialNumberHash'=>$client_obit->serial_number_hash,
            'metadata'=>[],
            'docLinks'=>[],
            'structuredData'=>[],
            'modifiedAt'=>$client_obit->updated_at
        ]);

        try {
            $obitApi->createObit($obit);
        } catch (Exception $e) {
            return response()->json([
                'status' => 1,
                'errorMessage'=>$e->getMessage()
            ], 500);
        }

        $device->synced_with_obada = 1;
        $device->save();

        return response()->json([
            'status' => 0
        ], 200);
    }

}
