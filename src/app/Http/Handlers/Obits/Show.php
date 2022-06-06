<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Obits;

use App\Http\Handlers\Handler;

class Show extends Handler {
    public function __invoke($key) {
        return view('obits.show', ['usn' => $key]);
    }
}