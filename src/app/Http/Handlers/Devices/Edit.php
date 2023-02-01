<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use App\ClientHelper\Token;

class Edit extends Handler {
    public function __invoke(string $usn)
    {
        $device = Auth::user()
            ->devices()
            ->byUsn($usn)
            ->first();

        if (! $device) {
            return abort(404);
        }

        $page = (object) [
            'title'             => 'Edit Device — USN ' . $device->usn,
            'breadcrumb_name'   => 'Edit Device',
            'description'       => '__description__',
            'keywords'          => '__keywords__',
            'isEdit'            => true,
        ];
        
        return view('devices.edit', [
            'page'          => $page,
            'account'       => request()->get('ch-account'),
            'device'        => $device,
            'usn'           => $usn
        ]);
    }
}
