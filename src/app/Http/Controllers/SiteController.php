<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function wallet(Request $request)
    {
        return view('pages.wallet', $this->getData([]));
    }
}
