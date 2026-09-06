<?php

return [

    /*
    |--------------------------------------------------------------------------
    | APP_NAME
    |--------------------------------------------------------------------------
    |
    | Este valor es el nombre de su aplicación, el cual se utilizará cuando el
    | framework necesite incluir el nombre de la aplicación en una notificación o
    | en otros elementos de la interfaz de usuario donde deba mostrarse dicho nombre.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    |APP_ENV
    |--------------------------------------------------------------------------
    |
    | Este valor determina el "entorno" en el que se está ejecutando actualmente tu aplicación.
    | Esto puede determinar cómo prefieres configurar los diversos
    | servicios que utiliza la aplicación. Establécelo en tu archivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application debugging mode
    |--------------------------------------------------------------------------
    |
    | Cuando la aplicación está en modo de depuración, se mostrarán mensajes de error detallados con
    | seguimientos de pila ante cualquier error que ocurra en la aplicación.
    | Si está desactivado, se mostrará una página de error genérica y sencilla.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL de la aplicación
    |--------------------------------------------------------------------------
    |
    | La consola utiliza esta URL para generar correctamente las URLs al emplear
    | la herramienta de línea de comandos Artisan. Debes configurarla apuntando a la raíz
    | de la aplicación para que esté disponible dentro de los comandos de Artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Zona horaria de la aplicación
    |--------------------------------------------------------------------------
    |
    | Aquí puede especificar la zona horaria predeterminada para su aplicación, la cual
    | será utilizada por las funciones de fecha y fecha-hora de PHP. La zona horaria
    | está establecida en "UTC" por defecto, ya que es adecuada para la mayoría de los 
      casos de uso.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Configuración de la configuración regional de la aplicación
    |--------------------------------------------------------------------------
    |
    | La configuración regional de la aplicación determina la configuración regional predeterminada que utilizarán
    | los métodos de traducción y localización de Laravel. Esta opción puede
    | establecerse en cualquier configuración regional para la que planees tener cadenas de traducción.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Clave de cifrado
    |--------------------------------------------------------------------------
    |
    | Esta clave es utilizada por los servicios de cifrado de Laravel y debe establecerse
    | como una cadena aleatoria de 32 caracteres para garantizar que todos los valores cifrados
    | sean seguros. Debes hacerlo antes de desplegar la aplicación.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Controlador de modo de mantenimiento
    |--------------------------------------------------------------------------
    |
    | Estas opciones de configuración determinan el controlador utilizado para determinar y
    | gestionar el estado del "modo de mantenimiento" de Laravel. El controlador "cache"
    | permitirá controlar el modo de mantenimiento en múltiples máquinas.
    |
    | Controladores admitidos: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
