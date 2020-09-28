<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Device;
use App\Models\ClientObit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DataController extends Controller
{
    public function get_devices_data(Datatables $datatables){
        return $datatables->eloquent(Device::orderBy('id', 'asc'))
            ->rawColumns(['id', 'manufacturer','part_number','serial_number','owner','synced_with_client_obits','synced_with_obada'])
            ->make(true);
    }
    public function get_obits_data(Datatables $datatables){
        return $datatables->eloquent(ClientObit::orderBy('id', 'asc'))
            ->rawColumns(['id', 'usn', 'part_number','manufacturer','owner'])
            ->make(true);
    }
}
