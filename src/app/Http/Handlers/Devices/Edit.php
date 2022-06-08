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
        
        return view('devices.edit', compact('usn'));
    }
}
