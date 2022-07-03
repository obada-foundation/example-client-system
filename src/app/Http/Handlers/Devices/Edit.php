<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;

class Edit extends Handler {
    public function __invoke(string $usn)
    {
        $user   = Auth::user();
        $device = $user->devices()->byUsn($usn)->first();

        if (! $device) {
            return abort(404);
        }

        $page = (object) [
            'title' => 'Edit Device',
            'description' => '__description__',
            'keywords' => '__keywords__',
            'isEdit' => true
        ];

        return view('devices.edit', compact('usn', 'page'));
    }
}
