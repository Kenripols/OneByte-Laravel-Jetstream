<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disco del sistema de archivos predeterminado
    |--------------------------------------------------------------------------
    |
    |Aquí puede especificar el disco del sistema de archivos predeterminado que utilizará
    | el framework. Tanto el disco "local" como diversas opciones de almacenamiento
    | en la nube están disponibles para que su aplicación almacene archivos.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Discos del sistema de archivos
    |--------------------------------------------------------------------------
    |
    | A continuación, puede configurar tantos discos de sistema de archivos como sea necesario, e
    | incluso puede configurar varios discos para el mismo controlador. Aquí se incluyen, a modo de referencia,
    | ejemplos para la mayoría de los controladores de almacenamiento compatibles.
    |
    | Controladores compatibles: "local", "ftp", "sftp", "s3"
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Enlaces simbólicos
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar los enlaces simbólicos que se crearán al ejecutar
    | el comando Artisan `storage:link`. Las claves del array deben ser
    | las ubicaciones de los enlaces y los valores, sus destinos.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
