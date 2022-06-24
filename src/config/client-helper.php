<?php

return [
    'token' => [
        'kid'              => env('OBADA_TOKEN_KID', '85bb2165-90e1-4134-af3e-90a4a0e1e2c1'),
        'private_key_path' => env('OBADA_PRIVATE_KEY', storage_path('certificates' . DIRECTORY_SEPARATOR . 'test.pem')), 
    ],
    'host' => env('CLIENT_HELPER_HOST', 'http://client-helper:9090/api/v1')
];