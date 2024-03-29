<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Login;

use App\Http\Handlers\Handler;

class Index extends Handler {
    public function __construct() {
        $this->middleware('guest');
    }

    public function __invoke()
    {
        return view('login.index');
    }
}
