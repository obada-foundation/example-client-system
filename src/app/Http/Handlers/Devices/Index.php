<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\ClientHelper\Token;
use App\Http\Handlers\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Obada\Api\AccountsApi;

class Index extends Handler {
    public function __invoke(Request $request, string $address)
    {
        $account = request()->get('ch-account');

        $nftCount = $account->getNftCount();
        
        $allByAddress = Auth::user()
            ->devices()
            ->where('address', $address)
            ->count();

        $mintedCount = 0;

        if ($nftCount) {
            $mintedCount = $allByAddress - $nftCount;
        }

        return view('devices.index', [
            'account'          => $account,
            'not_minted_count' => $mintedCount,
            'total_nft_count'  => $allByAddress,
            'transfer_success' => $request->has('transfer_success')
        ]);
    }
}
