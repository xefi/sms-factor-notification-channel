<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SMS "From" Number
    |--------------------------------------------------------------------------
    |
    | This configuration option defines the phone number that will be used as
    | the "from" number for all outgoing text messages.
    | See: https://dev.smsfactor.com/en/api/sms/getting-started
    |
    */

    'sms_from' => env('SMS_FACTOR_SMS_FROM'),

    /*
    |--------------------------------------------------------------------------
    | API Token
    |--------------------------------------------------------------------------
    |
    | This configuration contain your API token, which may be accessed
    | from your SMSFactor dashboard.
    |
    */

    'api_token' => env('SMS_FACTOR_TOKEN'),
];
