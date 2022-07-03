<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\ClientHelper\Token;
use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use Obada\Api\ObitApi;
use Obada\Api\UtilsApi;
use Obada\ClientHelper\GenerateObitDIDRequest;
use Throwable;
use Log;

class Show extends Handler
{
    public function __invoke(ObitApi $obitApi, UtilsApi $utilsApi, $usn)
    {
        $obit = [];
        $usn_data = null;
        $user = Auth::user();

        $device = $user->devices()
            ->with('documents')
            ->byUsn($usn)
            ->first();

        if (!$device) {
            // TODO: return with message
            return redirect()->route('devices.index');
        }

        $tokenCreator = app(Token::class);

        $obitApi->getConfig()->setAccessToken($tokenCreator->create($user));

        $obit = $obitApi->get($usn);

        try {
            $resp = $utilsApi->generateDID(
                (new GenerateObitDIDRequest())
                    ->setSerialNumber($device->serial_number)
                    ->setManufacturer($device->manufacturer)
                    ->setPartNumber($device->part_number)
            );

            $usn_data = (object) [
                'did'                => $resp->getDid(),
                'usn'                => $this->formatUsn($resp->getUsn()),
                'usn_base58'         => $resp->getUsnBase58(),
                'serial_number_hash' => $resp->getSerialNumberHash()
            ];
        } catch (Throwable $t) {
            Log::error("Cannot generate obit", [
                'error'   => $t->getMessage(),
                'context' => $t->getTraceAsString()
            ]);
        }

        return view('devices.show', [
            'page_title'    => 'Device Details — USN ' . $device->usn,
            'is_obit_page'  => false,
            'usn'           => $usn,
            'formatted_usn' => $this->formatUsn($usn),
            'device'        => $device,
            'obit'          => $obit,
            'usn_data'      => $usn_data
        ]);
    }

    function formatUsn(string $usn): string
    {
        $result = [];

        for ($i = 0; $i < strlen($usn); $i+=4) {
            $result[] = substr($usn, $i, 4);
        }
        return implode('-', $result);
    }
}
