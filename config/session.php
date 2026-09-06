<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | Esta opción determina el controlador de sesiones predeterminado que se utiliza para
    | las solicitudes entrantes. Laravel admite diversas opciones de almacenamiento para
    | persistir los datos de sesión. El almacenamiento en base de datos es una excelente 
    | opción predeterminada.
    |
    | Compatibles: "file", "cookie", "database", "apc",
    |              "memcached", "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Aquí puede especificar el número de minutos que desea permitir que la sesión
    | permanezca inactiva antes de caducar. Si desea que caduquen
    | inmediatamente al cerrar el navegador, puede
    | indicarlo mediante la opción de configuración expire_on_close..
    |
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | Esta opción te permite especificar fácilmente que todos los datos de tu sesión
    | se cifren antes de almacenarse. Todo el cifrado lo realiza
    | automáticamente Laravel y puedes utilizar la sesión con normalidad.
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | Al utilizar el controlador de sesiones "file", los archivos de sesión se almacenan
    | en el disco. Aquí se define la ubicación de almacenamiento predeterminada; sin embargo,
    | puedes especificar otra ubicación para guardarlos.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | Al utilizar los controladores de sesión "database" o "redis", puedes especificar
    | la conexión que se utilizará para gestionar dichas sesiones. Esta debe
    | corresponder a una conexión definida en las opciones de configuración de tu base de 
    | datos.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | Al utilizar el controlador de sesiones "database", puedes especificar la tabla
    | que se utilizará para almacenar las sesiones. Por supuesto, se define
    | un valor predeterminado razonable; sin embargo, puedes cambiarlo por otra tabla.
    |
    */

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | Al utilizar uno de los controladores de sesión del framework basados ​​en caché, puedes
    | definir el almacén de caché que se utilizará para guardar los datos de la sesión
    | entre peticiones. Este debe coincidir con uno de los almacenes de caché definidos.
    |
    | Afecta: "apc", "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Algunos controladores de sesión deben realizar un barrido manual de su ubicación de 
    | almacenamiento para eliminar las sesiones antiguas. A continuación se indican las 
    | probabilidades de que esto ocurra en una petición determinada. Por defecto, la 
    | probabilidad es de 2 entre 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Aquí puede cambiar el nombre de la cookie de sesión creada por
    | el framework. Por lo general, no debería necesitar cambiar este valor,
    | ya que hacerlo no aporta una mejora significativa en la seguridad.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | La ruta de la cookie de sesión determina la ruta para la cual la cookie
    | se considerará disponible. Por lo general, será la ruta raíz de
    | tu aplicación, pero puedes cambiarla cuando sea necesario.
    |
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Este valor determina el dominio y los subdominios para los cuales está disponible
    | la cookie de sesión. Por defecto, la cookie estará disponible para el dominio
    | raíz y todos los subdominios. Por lo general, no es necesario modificarlo.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | Al establecer esta opción como verdadera, las cookies de sesión solo se enviarán
    | al servidor si el navegador utiliza una conexión HTTPS. Esto evitará
    | que la cookie se envíe cuando no sea posible hacerlo de forma segura.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Establecer este valor en `true` impedirá que JavaScript acceda al
    | valor de la cookie, por lo que esta solo será accesible a través
    | del protocolo HTTP. Es poco probable que debas desactivar esta opción.
    |
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | Esta opción determina el comportamiento de las cookies cuando se producen solicitudes entre sitios
    | y puede utilizarse para mitigar ataques CSRF. De forma predeterminada,
    | estableceremos este valor en "lax" para permitir solicitudes seguras entre sitios.
    |
    | Ve: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#samesitesamesite-value
    |
    | Soporta: "lax", "strict", "none", null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Partitioned Cookies
    |--------------------------------------------------------------------------
    |
    | Establecer este valor en `true` vinculará la cookie al sitio de nivel superior
    | para un contexto entre sitios. El navegador acepta las cookies particionadas
    | cuando están marcadas como "secure" y el atributo `SameSite` está establecido 
    | en "none".
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
