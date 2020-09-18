<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function deviceDetail(Request $request, $obit_id)
    {
        return view('pages.device_detail',$this->getData([
            'device_id'=>$obit_id
        ]));
    }
    public function editDevice(Request $request, $obit_id)
    {
        return view('pages.edit_device',$this->getData([
            'device_id'=>$obit_id
        ]));
    }
    public function generateUsn(Request $request)
    {
        return view('pages.generate_usn',$this->getData([]));
    }
}
