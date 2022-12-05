<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;

class Create extends Handler {
    public function __invoke(string $address)
    {
        $page = (object) [
            'title'       => 'Add New Device',
            'description' => '__description__',
            'keywords'    => '__keywords__',
            'isEdit'      => false
        ];

        return view('devices.edit', compact('page', 'address'));
    }
}
