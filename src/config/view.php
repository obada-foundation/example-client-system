<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),


    /*
     *  Site name for the initial page
     */
    'site_name' => env(
        'SITE_NAME',
        'OBADA Reference Design'
    ),


    /*
     *  Defines how gas fee is shown
     */
    'gas_fee_text'     => env(
        'GAS_FEE_TEXT',
        'Gas Fee — ' . config('app.gas_fee') . ' OBD'
    ),
];
