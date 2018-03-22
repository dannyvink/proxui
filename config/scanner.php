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

    'port' => env('SCANNER_PORT')

];
