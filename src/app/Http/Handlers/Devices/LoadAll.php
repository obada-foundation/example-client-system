<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use Yajra\DataTables\DataTables;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class LoadAll extends Handler {
    public function __invoke(DataTables $datatables)
    {
        return $datatables->eloquent(Auth::user()->devices()->orderBy('id', 'asc'))
            ->rawColumns(['id', 'manufacturer','part_number','serial_number'])
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
            ->addColumn('documents_count', fn(Device $device) => $device->documents->count())
            ->make(true);
    }
}
