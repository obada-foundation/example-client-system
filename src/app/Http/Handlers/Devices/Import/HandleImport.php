<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices\Import;

use App\Http\Handlers\Handler;

class HandleImport extends Handler {
    public function __invoke(string $address)
    {
        $page = (object) [
            'title'       => 'Import CSV',
            'description' => '__description__',
            'keywords'    => '__keywords__'
        ];

        return view('devices.import', compact('page', 'address'));
    }
}
