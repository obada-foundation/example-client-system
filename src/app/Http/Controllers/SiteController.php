<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schema;

class SiteController extends Controller
{
    private function getData($a)
    {
        $data = array_merge([
            'is_authenticated'=>Auth::check(),
            'user'=>Auth::check()?Auth::user():null
        ], $a);
        return $data;
    }

    public function welcome(Request $request)
    {
        return view('pages.welcome',$this->getData([]));
    }

    public function deviceList(Request $request)
    {
        return view('pages.devices',$this->getData([]));
    }

    public function obitsList(Request $request)
    {
        return view('pages.obits',$this->getData([]));
    }

    public function deviceDetail(Request $request, $obit_id)
    {
        return view('pages.device_detail',$this->getData([
            'device_id'=>$obit_id
        ]));
    }


    public function deviceObitDetail(Request $request, $usn)
    {
        return view('pages.device_obit_detail',$this->getData([
            'usn'=>$usn
        ]));
    }


    public function obitDetail(Request $request, $usn)
    {
        return view('pages.obit_detail',$this->getData([
            'usn'=>$usn
        ]));
    }

    public function editDevice(Request $request, $obit_id)
    {
        $schema = Schema::all(); //Temporarily adding schema to page. This should be converted into a web-service eventually.
        return view('pages.edit_device',$this->getData([
            'device_id'=>$obit_id,
            'schema'=>$schema
        ]));
    }
    public function generateUsn(Request $request)
    {
        return view('pages.generate_usn',$this->getData([]));
    }
    public function retrieveObit(Request $request)
    {
        return view('pages.retrieve_obit',$this->getData([]));
    }

    public function generateHashing(Request $request)
    {
        return view('pages.generate_hashing',$this->getData([]));
    }
}
