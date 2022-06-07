<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Login;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthenticateRequest;

class Authenticate extends Handler {
    
    public function __construct() {
        $this->middleware('guest');
    }

    public function __invoke(AuthenticateRequest $request)
    {   
        $credentials = $request->only('email', 'password');

        if(!Auth::validate($credentials)) {
            return redirect()->route('login.index')
                ->withErrors(['password' => 'Login details are not valid'])
                ->withInput($request->except('password'));
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user, $request->get('remember'));

        return redirect()->intended('/')->withSuccess('Signed in');
    }
}
