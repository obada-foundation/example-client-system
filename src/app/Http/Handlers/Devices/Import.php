<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;

class Import extends Handler {
    public function __invoke()
    {
        $page = (object) [
            'title'       => 'Import CSV',
            'description' => '__description__',
            'keywords'    => '__keywords__'
        ];

        return view('devices.import', compact('page'));
    }
}
