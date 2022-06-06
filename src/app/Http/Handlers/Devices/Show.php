<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;

class Show extends Handler {
    public function __invoke($usn)
    {
        return view('devices.show', ['device_id' => $usn]);
    }
}