<?php

declare(strict_types=1);

namespace App\Http\Handlers\Addresses;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use function view;

class GeneratePhrase extends Handler {
    public function __invoke(Request $request)
    {
        switch ($request->input('step')) {
            case 1:
                $page_title = 'Generate New Seed Phrase';
                break;
            default:
                $page_title = 'Generate New Address';
        }

        return view('addresses.generate-phrase', [
            'seed_phrase' => 'suggest quit betray lunar direct agent trial royal range feel spare awake',
            'seed_phrase_short' => 'suggest ... awake',
            'address' => '0xF2CBB6aea7dc606c5E4a241533DA71F0872Cd49d',
            'step' => $request->input('step'),
            'page_title' => $page_title
        ]);
    }
}
