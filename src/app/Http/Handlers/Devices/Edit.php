<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;

class Edit extends Handler {
    public function __invoke(string $usn)
    {
        $user   = Auth::user();
        $device = $user->devices()->byUsn($usn)->first();

        if (! $device) {
            return abort(404);
        }

        $address = $device->address;

        $page = (object) [
            'title'             => 'Edit Device — USN ' . $device->usn,
            'breadcrumb_name'   => 'Edit Device',
            'description'       => '__description__',
            'keywords'          => '__keywords__',
            'isEdit'            => true,
        ];

        return view('devices.edit', [
            'page'          => $page,
            'address'       => $address,
            'address_short' => substr($address, 0, 10) . '...' . substr($address, -4),
            'device'        => $device,
            'usn'           => $usn
        ]);
    }
}
