<?php

namespace App\Http\Controllers;

use App\Facades\ObadaClient;
use App\Models\Device;
use Log;
use Obada\Api\HelperApi;
use Obada\Api\ObitApi;
use Obada\Entities\Obit;
use Yajra\DataTables\DataTables;
use Exception;

class DataController extends Controller
{
    public function __construct(protected ObitApi $obitApi, protected HelperApi $helperApi)
    {
    }

    /**
     * Returns Devices in a Datatables format.
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function getDevicesData(Datatables $datatables)
    {
        return $datatables->eloquent(Device::orderBy('id', 'asc'))
            ->rawColumns(['id', 'manufacturer','part_number','serial_number','owner'])
            ->addColumn('local_hash', function (Device $device) {
                try {
                    $result = $this->helperApi->generateRootHash($device->getLocalObit());
                    return $result['rootHash'];
                } catch (\Exception) {
                    return '';
                }
            })
            ->addColumn('root_hash', function (Device $device) {
                //Get Client Obit
                try {
                    $result = $this->helperApi->getClientObit($device->obit_did);
                    return $result['obit']['rootHash'];
                } catch (\Exception) {
                    return '';
                }
            })
            ->addColumn('obada_hash', function (Device $device) {
                //Get Server Obit
                try {
                    $result = $this->helperApi->fetchObitFromChain($device->obit_did);
                    return $result['blockchainObit']['rootHash'];
                } catch (\Exception) {
                    return '';
                }
            })
            ->make(true);
    }

    /**
     * Returns Obits in a DataTables format
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function getObitsData(Datatables $datatables)
    {
        $result = $this->helperApi->getClientObits();
        $obits = collect($result->getObits())
            ->map(fn (Obit $o) => (array) $o->jsonSerialize());

        return $datatables->collection($obits)
            ->rawColumns(['id', 'usn', 'serial_number_hash', 'part_number','manufacturer','owner_did','root_hash'])
            ->addColumn('local_hash', function ($client_obit) {
                $device = Device::where([
                    'obit_did' => "did:obada:" . $client_obit['obit_did']
                ])->first();
                if ($device) {
                    $result = $this->helperApi->generateRootHash($device->getLocalObit());
                    return $result->getRootHash();
                } else {
                    return '';
                }
            })
            ->addColumn('obada_hash', function ($client_obit) {
                $result = $this->helperApi->fetchObitFromChain("did:obada:" . $client_obit['obit_did']);

                return $result->getBlockchainObit()->getRootHash();
            })
            ->make(true);
    }
}
