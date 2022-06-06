<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;

class Index extends Handler {
    public function __invoke()
    {
        return view('devices.index');
    }
}
