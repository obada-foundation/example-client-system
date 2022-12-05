<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Device;
use Obada\Api\AccountsApi;
use App\ClientHelper\Token;

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
            $token = app(Token::class)->create(Auth::user());

            $accountsApi = app(AccountsApi::class);
            $accountsApi->getConfig()
                ->setAccessToken($token);

            $accounts = $accountsApi->accounts();

            if (!$accounts->getData() || count($accounts->getData()) == 0) {
                return redirect()->route('addresses.index');
            } 

            return redirect()->route('addresses.index', ['show_data' => 1]);
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
}
