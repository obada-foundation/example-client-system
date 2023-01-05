<?php

declare(strict_types=1);

namespace App\Http\Handlers\Accounts;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Illuminate\Support\Facades\Validator;
use Obada\Api\AccountsApi;
use Obada\ClientHelper\MnemonicRequest;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SavePhrase extends Handler {
    public function __invoke(Request $request)
    {
        $words = explode(' ', session()->get('mnemonic'));

        if (count($words) == 0) {
            throw new Exception('Mnemonic must exists in session');
        }

        if ($words[2-1] !== request()->get('word2')){
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['word2' => 'Mnemonic seed validation failed.']);
        } 
        
        if ($words[7-1] !== request()->get('word7')) {
            return redirect()
                >back()
                ->withInput()
                ->withErrors(['word7' => 'Mnemonic seed validation failed.']);
        }

        $token = app(Token::class)->create(Auth::user());

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $req = (new MnemonicRequest)
            ->setMnemonic(session()->get('mnemonic'));

        $api->newWallet($req);

        return Redirect::route('accounts.index', ['show_data' => 1, 'has_accounts' => 1]);
    }
}
