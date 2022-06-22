<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use Obada\Api\ObitApi;
use Throwable;
use Log;

class Show extends Handler
{
    public function __invoke(ObitApi $api, $usn)
    {
        $device = Auth::user()->devices()->with('documents')
            ->byUsn($usn)
            ->first();

        if (!$device) {
            return redirect()->route('devices.index');
        }

        try {
            $obit = $api->get($usn);
        } catch (Throwable $t) {
            $obit = [];
            Log::info($t->getMessage());
        }

        return view('devices.show', [
            'device_id' => $usn,
            'device' => $device,
            'obit' => $obit
        ]);
    }
}
