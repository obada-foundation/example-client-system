<?php

declare(strict_types=1);

namespace App\Http\Handlers\NFT\Transfer;

use App\Http\Handlers\Handler;
use function view;

class Index extends Handler {
    public function __invoke(string $usn)
    {
        return view('transfer.index', ['usn' => $usn]);
    }
}
