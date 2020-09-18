<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\ClientObit;
use App\ObitManager\ObitManager;
use App\Http\Requests\UsnRequest;

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
        $device = Device::with('metadata','documents','structured_data')->find($request->input('device_id'));
        $usn = $manager->GenerateUSN($input['manufacturer'],$input['part_number'],$input['serial_number']);
        $client_obit = ClientObit::where([
            'usn'=>$usn['usn']
        ])->first();

        if(!$client_obit) {
            $client_obit = new ClientObit();
        }

        $client_obit->manufacturer = $device->manufacturer;
        $client_obit->owner = $device->owner;
        $client_obit->part_number = $device->part_number;
        $client_obit->serial_number_hash = $manager->GenerateHash($device->serial_number);
        $client_obit->status = 0;
        $client_obit->metadata = $device->metadata()->toJson();
        $client_obit->documents = $device->documents()->toJson();
        $client_obit->structured_data = $device->structured_data()->toJson();
        $client_obit->root_hash = $manager->GenerateRootHash();

        $client_obit->save();
        //$clientObit = new ClientObit();

    }



}
