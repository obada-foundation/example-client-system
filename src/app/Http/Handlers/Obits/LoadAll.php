<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Obits;

use App\Http\Handlers\Handler;
use App\Models\Device;
use Throwable;
use Log;

class LoadAll extends Handler {
    public function __invoke() {
        try {
            $devices = Device::hasLocalObits()->get();

            return response()->json([
                'status' => 0,
                'data'   => $devices
            ], 200);
        } catch (Throwable $t) {
            Log::info($t->getMessage());
            return response()->json([
                'status'       => 1,
                'errorMessage' => 'Error Getting Client Obit'
            ], 400);
        }
    }
}