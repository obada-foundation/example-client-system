<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Device;
use App\Models\ClientObit;
use Log;
use Obada\Api\ObitApi;
use Obada\ApiException;
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
        $obitApi = new ObitApi();
        return $datatables->eloquent(Device::orderBy('id', 'asc'))
            ->rawColumns(['id', 'manufacturer','part_number','serial_number','owner'])
            ->addColumn('root_hash', function(Device $device) {

                $client_obit = ClientObit::where([
                    'usn'=>$device->usn
                ])->first();
                if($client_obit) {
                    return $client_obit->root_hash;
                }

                return '';

            })
            ->addColumn('obada_hash', function(Device $device) use ($obitApi) {
                try {
                    $client_obit = ClientObit::where([
                        'usn'=>$device->usn
                    ])->first();
                    if(!$client_obit) {
                        return '';
                    }

                    $obit = $obitApi->showObit($client_obit->obit_did);
                    return $obit->getRootHash();
                } catch(ApiException | Exception $e) {
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
        $obitApi = new ObitApi();

        return $datatables->eloquent(ClientObit::orderBy('id', 'asc'))
            ->rawColumns(['id', 'usn', 'serial_number_hash', 'part_number','manufacturer','owner_did','root_hash'])
            ->addColumn('obada_hash', function(ClientObit $client_obit) use ($obitApi) {
                try {
                    $obit = $obitApi->showObit($client_obit->obit_did);
                    return $obit->getRootHash();
                } catch(ApiException | Exception $e) {
                    Log::info($e->getMessage());
                    return '';
                }
            })
            ->make(true);
    }
}
