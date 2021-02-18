<?php

namespace App\Http\Controllers;

use App\Facades\ObadaClient;
use App\Models\Device;
use Log;
use Yajra\DataTables\DataTables;
use Exception;

class DataController extends Controller
{
    /**
     * Returns Devices in a Datatables format.
     * @param DataTables $datatables
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function get_devices_data(Datatables $datatables){
        return $datatables->eloquent(Device::orderBy('id', 'asc'))
            ->rawColumns(['id', 'manufacturer','part_number','serial_number','owner'])
            ->addColumn('local_hash', function(Device $device) {
                try {
                    $result = ObadaClient::generateRootHash($device->getLocalObit());
                    return $result['rootHash'];
                } catch(\Exception $e) {
                    return '';
                }
            })
            ->addColumn('root_hash', function(Device $device) {
                //Get Client Obit
                try {
                    $result = ObadaClient::getClientObit($device->obit_did);
                    return $result['obit']['rootHash'];
                } catch(\Exception $e) {
                    return '';
                }



            })
            ->addColumn('obada_hash', function(Device $device) {
                //Get Server Obit
                try {
                    $result = ObadaClient::fetchObitFromChain($device->obit_did);
                    return $result['blockchainObit']['rootHash'];
                } catch(\Exception $e) {
                    return '';
                }


            })
            ->make(true);
    }

    /**
     * Returns Obits in a DataTables format
     * @param DataTables $datatables
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function get_obits_data(Datatables $datatables){

        $result = ObadaClient::getClientObits();
        $obits = collect($result['obits']->toArray());


        return $datatables->collection($obits)
            ->rawColumns(['id', 'usn', 'serial_number_hash', 'part_number','manufacturer','owner_did','root_hash'])
            ->addColumn('local_hash', function($client_obit) {
                $device = Device::where([
                    'obit_did'=>$client_obit->obit_did
                ])->first();
                if($device) {
                    $result = ObadaClient::generateRootHash($device->getLocalObit());
                    return $result['root_hash'];
                } else {
                    return '';
                }
            })
            ->addColumn('obada_hash', function($client_obit) {
                $result = ObadaClient::fetchObitFromChain($client_obit->obit_did);
                return $result['blockchain_obit']['root_hash'];
            })
            ->make(true);
    }
}
