<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schema;
use App\Facades\ObadaClient;

class SiteController extends Controller
{
    private function getData($a)
    {
        return array_merge([
            'is_authenticated' => Auth::check(),
            'user'             => Auth::check() ? Auth::user() : null
        ], $a);
    }

    public function welcome(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('devices.index');
        } else {
            return view('pages.welcome', $this->getData([]));
        }
    }

    public function obitsList(Request $request)
    {
        return view('pages.obits', $this->getData([]));
    }

    public function deviceObitDetail(Request $request, $obit_did)
    {
        return view('pages.device_obit_detail', $this->getData([
            'obit_did' => $obit_did
        ]));
    }

    public function obitDetail(Request $request, $usn)
    {
        return view('pages.obit_detail', $this->getData([
            'usn' => $usn
        ]));
    }

    public function generateUsn(Request $request)
    {
        return view('pages.generate_usn', $this->getData([]));
    }
    public function retrieveObit(Request $request)
    {
        return view('pages.retrieve_obit', $this->getData([]));
    }

    public function generateHashing(Request $request)
    {
        return view('pages.generate_hashing', $this->getData([]));
    }

    public function documentation(Request $request)
    {
        return view('pages.documentation', $this->getData([]));
    }
}
