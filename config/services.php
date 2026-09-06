<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services (Servicios de terceros)
    |--------------------------------------------------------------------------
    |
    | Este archivo sirve para almacenar las credenciales de servicios de terceros, como
    | Mailgun, Postmark, AWS y otros. Este archivo constituye la ubicación
    | estándar para este tipo de información, permitiendo que los paquetes dispongan
    | de un archivo convencional donde localizar las credenciales de los distintos servicios.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
