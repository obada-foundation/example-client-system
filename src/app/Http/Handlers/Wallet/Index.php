<?php

declare(strict_types=1);

namespace App\Http\Handlers\Wallet;

use App\Http\Handlers\Handler;
use function view;
use Illuminate\Support\Facades\Auth;

class Index extends Handler {
    public function __invoke($address)
    {
        $account = request()->get('ch-account');

        return view('wallet.index', [
            'account' => $account,
        ]);
    }
}
