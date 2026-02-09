<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default SMS Driver
    |--------------------------------------------------------------------------
    | Here you may specify the default SMS driver that will be used to send SMS messages.
    | You may use any of the drivers defined in the "drivers" array below. The "log" driver
    | is a great option for development and testing, while the "array" driver can be used for unit testing.
    */
    'default' => env('SMS_DRIVER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | SMS Drivers
    |--------------------------------------------------------------------------
    | Here you may configure as many SMS drivers as you wish, and you may even configure multiple drivers
    | of the same type. Drivers are used to send SMS messages using different services or methods.
    */
    'drivers' => [

        /*
        |----------------------------------------------------------------------
        | Log Driver
        |--------------------------------------------------------------------------
        | The "log" driver writes SMS messages to the log files, which is useful for development and testing.
        */
        'log' => [
            'driver' => 'log',
        ],

        /*
        |--------------------------------------------------------------------------
        | Array Driver
        |--------------------------------------------------------------------------
        | The "array" driver stores SMS messages in an array, which is useful for unit testing.
        */
        'array' => [
            'driver' => 'array',
        ],
    ],
];
