<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Scanner Port
    |--------------------------------------------------------------------------
    |
    | This option should be set to the correct port used to access the scanner.
    | On a Mac or Linux xystem, this will be something like '/dev/tty.usb***'.
    | On a Windows system, this will look like 'COM*'.
    |
    */

    'port' => env('SCANNER_PORT'),

    /*
    |--------------------------------------------------------------------------
    | Wi-Fi Interface
    |--------------------------------------------------------------------------
    |
    | This option should be set to the correct Wi-Fi interface on the device.
    |
    */

    'wifi_interface' => env('WIFI_INTERFACE', 'wlan1')

];
