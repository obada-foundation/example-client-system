<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Device;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DataController extends Controller
{
    public function get_devices_data(Datatables $datatables){
        return $datatables->eloquent(Device::orderBy('id', 'asc'))
            ->rawColumns(['id', 'manufacturer','part_number','serial_number','owner','actions'])
            ->make(true);
    }
    public function get_obits_data(Datatables $datatables){
        return $datatables->eloquent(ClientObit::orderBy('id', 'asc'))
            ->rawColumns(['id', 'usn','obit','manufacturer','part_number','serial_number','owner'])
            ->make(true);
    }
}
