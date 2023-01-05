<?php

declare(strict_types=1);

namespace App\Http\Handlers\Accounts;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Obada\Api\AccountsApi;
use App\ClientHelper\Token;
use Illuminate\Support\Facades\Auth;
use function view;

class GeneratePhrase extends Handler {
    public function __invoke(Request $request, AccountsApi $api)
    {
        switch ($request->input('step')) {
            case 1:
                $token = app(Token::class)->create(Auth::user());
                $api->getConfig()->setAccessToken($token);

                $mnemonic = $api->newMnemonic()->getMnemonic();

                session()->put('mnemonic', $mnemonic);

                $page_title = 'Generate New Seed Phrase';
                break;
            default:
                $mnemonic   = '';
                $page_title = 'Generate New Address';
        }

        return view('accounts.generate-phrase', [
            'seed_phrase'       => $mnemonic,
            'seed_phrase_short' => 'suggest ... awake',
            'address'           => '0xF2CBB6aea7dc606c5E4a241533DA71F0872Cd49d',
            'step'              => $request->input('step'),
            'page_title'        => $page_title
        ]);
    }
}
