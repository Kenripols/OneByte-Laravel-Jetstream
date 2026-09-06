<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | Esta opción controla el sistema de envío de correo predeterminado que se utiliza 
    | para enviar todos los mensajes de correo electrónico, a menos que se especifique 
    | explícitamente otro sistema al enviar el mensaje. Los sistemas de envío adicionales 
    | pueden configurarse dentro de la matriz "mailers". Se proporcionan ejemplos de cada 
    | tipo de sistema de envío.
    |
    */

    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar todos los sistemas de envío de correo que utiliza tu aplicación,
    | así como sus respectivas configuraciones. Se han configurado varios ejemplos
    | para ti, y eres libre de añadir los tuyos propios según las necesidades de tu aplicación.
    |
    | Laravel admite diversos controladores de "transporte" de correo que pueden utilizarse
    | para enviar mensajes. A continuación, puedes especificar cuál utilizarás para
    | tus sistemas de envío de correo. También puedes añadir otros adicionales si es necesario.
    |
    | Compatible: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |             "postmark", "resend", "log", "array",
    |             "failover", "roundrobin"
    |
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | Es posible que desee que todos los correos electrónicos enviados por su aplicación se envíen desde
    | la misma dirección. Aquí puede especificar un nombre y una dirección que se
    | utilizarán de forma global para todos los correos electrónicos enviados por su aplicación.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

];
