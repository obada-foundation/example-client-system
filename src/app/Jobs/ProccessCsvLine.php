<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Obada\ClientHelper\GenerateObitDIDRequest;
use App\Events\DeviceSaved;
use Obada\Api\UtilsApi;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProccessCsvLine implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected User $user,
        protected string $address,
        protected string $serialNumber,
        protected string $manufacturer,
        protected string $partNumber
    ) {

    }

    public function handle(UtilsApi $utilsApi)
    {
        $did = $utilsApi->generateDID(
            (new GenerateObitDIDRequest())
                ->setSerialNumber($this->serialNumber)
                ->setManufacturer($this->manufacturer)
                ->setPartNumber($this->partNumber)
        );

        $existingDevice = Device::byUsn($did->getUsn())
            ->where('user_id', $this->user->id)
            ->where('address', $this->address)
            ->first();

        if ($existingDevice) return;

        $device = Device::create([
            'user_id'       => $this->user->id,
            'serial_number' => $this->serialNumber,
            'manufacturer'  => $this->manufacturer,
            'part_number'   => $this->partNumber,
            'address'       => $this->address,
            'usn'           => $did->getUsn(),
            'obit_did'      => $did->getDid(),
        ]);

        DeviceSaved::dispatch($this->user, $device);
    }
}