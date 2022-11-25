<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Register;

use Illuminate\Support\Facades\DB;
use App\Http\Handlers\Handler;

class Index extends Handler {
    public function __construct() {
        $this->middleware('guest');
    }

    public function __invoke()
    {
        return view('register.index');
    }
}
