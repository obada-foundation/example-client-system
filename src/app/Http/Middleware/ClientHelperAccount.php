<?php

namespace App\Http\Middleware;

use Closure;
use Obada\Api\AccountsApi;
use App\ClientHelper\Account;
use InvalidArgumentException;
use Illuminate\Support\Facades\Auth;

class ClientHelperAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($request->get('ch-token'));

        if ($request->route('address')) {
            $account = Account::make($api->account($request->route('address')));
        }

        if ($request->route('usn')) {
            $device = Auth::user()
                ->devices()
                ->where('usn', $request->route('usn'))
                ->first();

            if ($device) {
                $account = Account::make($api->account($device->address));
            }
        }

        if (! isset($account)) {
            throw new InvalidArgumentException;
        }

        $request->merge(['ch-account' => $account]);
        
        return $next($request);
    }
}
