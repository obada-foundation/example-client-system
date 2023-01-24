<?php

namespace App\Providers;

use App\Events\DeviceSaved;
use App\Events\DeviceImported;
use App\Listeners\ClientHelperSave;
use App\Listeners\ClientHelperImport;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\RegisterOBADAAccount;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            RegisterOBADAAccount::class
        ],
        DeviceSaved::class => [
            ClientHelperSave::class
        ],

        DeviceImpoted::class => [
            ClientHelperImport::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
