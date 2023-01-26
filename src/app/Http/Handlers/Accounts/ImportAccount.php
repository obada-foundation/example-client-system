<?php

declare(strict_types=1);

namespace App\Http\Handlers\Accounts;

use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use function view;

class ImportAccount extends Handler {
    public function __invoke(Request $request)
    {
        return view('accounts.import-account');
    }
}
