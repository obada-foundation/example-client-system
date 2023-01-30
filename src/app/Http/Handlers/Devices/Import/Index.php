<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices\Import;

use App\Http\Handlers\Handler;

class Index extends Handler {
    public function __invoke(string $address)
    {
        $page = (object) [
            'title'       => 'Import CSV',
            'description' => '__description__',
            'keywords'    => '__keywords__'
        ];

        return view('devices.import', [
            'page'          => $page,
            'address'       => $address,
            'address_short' => substr($address, 0, 10) . '...' . substr($address, -4)
        ]);
    }
}
