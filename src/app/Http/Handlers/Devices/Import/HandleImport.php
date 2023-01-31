<?php

declare(strict_types=1);

namespace App\Http\Handlers\Devices\Import;

use App\Http\Handlers\Handler;
use Illuminate\Support\Facades\Auth;
use Throwable;
use App\Jobs\ProccessCsvLine;
use Illuminate\Validation\ValidationException;

class HandleImport extends Handler {
    public function __invoke(string $address)
    {
        $importData = explode(PHP_EOL, request()->get('csv'));

        foreach ($importData as $importDeviceStr) {
            try {
                if (!strlen($importDeviceStr)) {
                    continue;
                }

                $importDevice = str_getcsv($importDeviceStr);

                ProccessCsvLine::dispatch(
                    Auth::user(),
                    $address,
                    trim($importDevice[2]),
                    trim($importDevice[0]),
                    trim($importDevice[1])
                );
            } catch (ValidationException $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['csv' => $e->errors()['csv'][0]]);
            } catch (Throwable $t) {
                report($t);

                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['csv' => sprintf('Wrong data format. Invalid line: %s.', $importDeviceStr)]);
            }
        }

        return redirect()->route('devices.index', $address);
    }
}
