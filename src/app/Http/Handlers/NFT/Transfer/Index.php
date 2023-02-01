<?php

declare(strict_types=1);

namespace App\Http\Handlers\NFT\Transfer;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use function view;

class Index extends Handler {
    public function __invoke(string $usn)
    {
        $device = Auth::user()->devices()->byUsn($usn)->first();

        if (! $device) {
            return abort(404);
        }

        return view('transfer.index', [
            'usn'     => $usn,
            'address' => $device->address,
            'account' => request()->get('ch-account')
        ]);
    }
}
