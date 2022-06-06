<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ObadaClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'obada_client';
    }
}
