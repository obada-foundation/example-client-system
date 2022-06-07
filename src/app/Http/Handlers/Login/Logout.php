<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Login;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;

class Logout extends Handler {
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke()
    {
        Auth::logout();

        return redirect()->to('/');
    }
}
