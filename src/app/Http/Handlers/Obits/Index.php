<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Obits;

use App\Http\Handlers\Handler;

class Index extends Handler {
    public function __invoke() {
        return view('obits.index');
    }
}