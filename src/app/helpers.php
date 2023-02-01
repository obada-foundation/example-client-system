<?php

if (! function_exists('shortifyAddress')) {
    function shortifyAddress(string $address) : string {
        return substr($address, 0, 10) . '...' . substr($address, -4);
    }
}