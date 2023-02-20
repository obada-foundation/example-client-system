<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use Yajra\DataTables\DataTables;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Obada\Api\NFTApi;
use App\ClientHelper\Token;

class LoadAll extends Handler {
    public function __invoke(NFTApi $api, DataTables $datatables)
    {
        $user = Auth::user();
        $token = app(Token::class)->create($user);
        $api->getConfig()->setAccessToken($token);

        $devices = $user->devices()
            ->with(['documents'])
            ->where('address', request()->query('address'))
            ->orderBy('id', 'asc');

        return $datatables->eloquent($devices)
            ->rawColumns(['id', 'manufacturer','part_number','serial_number', 'obit_checksum'])
            ->addColumn('blockchain_checksum', function (Device $device) use ($api) {
                //Get Client Obit
                try {
                   // return '';
                    $pNFT = $api->nft($device->usn);
                    return $pNFT->getData()->getChecksum();
                } catch (\Exception $e) {
                    return '';
                }
            })
            ->addColumn('documents_count', fn(Device $device) => $device->documents->count())
            ->addColumn('image', function (Device $device) {
                $image = $device->documents->first(function($document) {
                    return $document->name == 'image';
                });

//                return $image ? $image->path : '';
                return $image ? '/images/laptop.png' : '';
            })
            ->make(true);
    }
}
