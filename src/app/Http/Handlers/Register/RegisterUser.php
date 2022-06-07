<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Register;

use App\Models\User;
use App\Http\Handlers\Handler;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Events\Registered;

class RegisterUser extends Handler {
    public function __construct() {
        $this->middleware('guest');
    }

    public function __invoke(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->email_verified_at = Carbon::now();
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    }
}
