<?php

declare(strict_types=1);

namespace App\Http\Handlers\Addresses;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SavePhrase extends Handler {
    public function __invoke(Request $request)
    {
        return Redirect::route('addresses.index', ['show_data' => 1, 'has_addresses' => 1]);
    }
}
