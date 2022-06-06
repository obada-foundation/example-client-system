<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Generate\Checksum;

use App\Http\Handlers\Handler;

class Index extends Handler {
    public function __invoke()
    {
        return view('generate.checksum');
    }
}
