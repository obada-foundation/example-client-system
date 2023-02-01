<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices;

use App\ClientHelper\Token;
use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Obada\Api\ObitApi;
use Obada\Api\UtilsApi;
use Obada\Api\NFTApi;
use Obada\ClientHelper\GenerateObitDIDRequest;
use Obada\ClientHelper\GenerateObitChecksumRequest;
use Obada\ApiException;
use Throwable;

class Show extends Handler
{
    public function __invoke(ObitApi $obitApi, UtilsApi $utilsApi, NFTApi $nftApi, $usn)
    {
        $obit = [];
        $usn_data = null;
        $user = Auth::user();

        $device = $user->devices()
            ->with('documents')
            ->byUsn($usn)
            ->first();

        if (!$device) {
            return redirect()
                ->route('accounts.index')
                ->withErrors(['error' => 'A device does not exist']);
        }

        $token = app(Token::class)->create($user);
        $obitApi->getConfig()->setAccessToken($token);
        $nftApi->getConfig()->setAccessToken($token);

        $obit = $obitApi->get($usn);

        $hasNFT = true;

        try {
            $nftApi->nft($usn);
        } catch (ApiException $t) {
            $hasNFT = false;
        }

        try {
            $respChecksum = $utilsApi->generateChecksum(
                (new GenerateObitChecksumRequest())
                    ->setSerialNumber($device->serial_number)
                    ->setManufacturer($device->manufacturer)
                    ->setPartNumber($device->part_number)
            );

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
                'serial_number_hash' => $resp->getSerialNumberHash(),
            ];

        } catch (Throwable $t) {
            Log::error("Cannot generate obit checksum", [
                'error'   => $t->getMessage(),
                'context' => $t->getTraceAsString()
            ]);

            return redirect()->back();
        }

        $device->documents->map(function ($document) {
            if (preg_match('/^(ipfs):\/\/(.*)$/m', $document->path, $ipfsUrl)) {
                $ipfsHash = $ipfsUrl[2];

                $document->path = 'http://ipfs.alpha.obada.io:8080/ipfs/' . $ipfsHash;
            }

            return $document;
        });

        return view('devices.show', [
            'page_title'    => 'Device Details — USN ' . $device->usn,
            'usn'           => $usn,
            'formatted_usn' => $this->formatUsn($usn),
            'device'        => $device,
            'obit'          => $obit,
            'usn_data'      => $usn_data,
            'hasNFT'        => $hasNFT,
            'account'       => request()->get('ch-account'),
            'compute_log'   => str_replace(['<|', '|>'], ['<br/><br />',''], $respChecksum->getComputeLog()),
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
