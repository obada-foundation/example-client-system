<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;

class Show extends Handler
{
    public function __invoke($usn)
    {
        $device = Auth::user()->devices()->with('documents')
            ->byUsn($usn)
            ->first();

        return view('devices.show', [
            'device_id' => $usn,
            'device' => $device,
        ]);
    }
}
