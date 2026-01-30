<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'xano' => [
        'base_url' => env('XANO_API_BASE_URL'),
        'key' => env('XANO_API_KEY'),
        'timeout' => env('XANO_API_TIMEOUT', 30), // Request timeout in seconds
        'retry_times' => env('XANO_API_RETRY_TIMES', 3), // Number of retry attempts
        'retry_delay' => env('XANO_API_RETRY_DELAY', 100), // Delay between retries in milliseconds
        'cache_ttl' => env('XANO_API_CACHE_TTL', 3600), // Cache TTL in seconds (1 hour)
    ],

];
