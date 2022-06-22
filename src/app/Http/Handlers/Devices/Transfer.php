<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use function view;

class Transfer extends Handler {
    public function __invoke(string $usn)
    {
        return view('devices.transfer', [
            'usn' => $usn
        ]);
    }
}
