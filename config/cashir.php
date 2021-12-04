<?php

return [
    'staging' => [
        'FRONTEND_TEST_URL' => env('FRONTEND_TEST_URL', ''),
        'TWILIO_SID' => env('TWILIO_SID', ''),
        'TWILIO_AUTH_TOKEN' => env('TWILIO_AUTH_TOKEN', ''),
        'TWILIO_VERIFY_SID' => env('TWILIO_VERIFY_SID', ''),
        'TWILIO_PHONE' => env('TWILIO_PHONE', ''),
    ],
    'production' => [
        'FRONTEND_URL' => env('FRONTEND_URL', ''),
        'TWILIO_SID' => env('TWILIO_SID', ''),
        'TWILIO_AUTH_TOKEN' => env('TWILIO_AUTH_TOKEN', ''),
        'TWILIO_VERIFY_SID' => env('TWILIO_VERIFY_SID', ''),
        'TWILIO_PHONE' => env('TWILIO_PHONE', ''),
    ]
];
