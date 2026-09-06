<?php

use Laravel\Fortify\Features;

return [

    /*
    |--------------------------------------------------------------------------
    | Guardia fortificada
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar qué guardián de autenticación utilizará Fortify al
    | autenticar a los usuarios. Este valor debe corresponder a uno de los
    | guardianes ya definidos en tu archivo de configuración "auth".
    |
    */

    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Agente de contraseñas Fortify
    |--------------------------------------------------------------------------
    |
    | Aquí puede especificar qué gestor de contraseñas puede utilizar Fortify cuando un usuario
    | restablece su contraseña. Este valor configurado debe coincidir con uno
    | de los gestores de contraseñas definidos en su archivo de configuración "auth".
    |
    */

    'passwords' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Nombre de usuario / Correo electrónico
    |--------------------------------------------------------------------------
    |
    | Este valor define qué atributo del modelo debe considerarse como el campo
    | de "nombre de usuario" de tu aplicación. Por lo general, suele ser la
    | dirección de correo electrónico de los usuarios, pero puedes cambiar este valor aquí.
    |
    | Por defecto, Fortify espera que las solicitudes de recuperación y
    | restablecimiento de contraseña incluyan un campo llamado 'email'. Si la
    | aplicación utiliza otro nombre para dicho campo, puedes definirlo a continuación según sea necesario.
    |
    */

    'username' => 'email',

    'email' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Nombres de usuario en minúsculas
    |--------------------------------------------------------------------------
    |
    | Este valor determina si los nombres de usuario deben convertirse a minúsculas 
    | antes de guardarlos en la base de datos, ya que algunos campos de texto de los 
    | sistemas de bases de datos distinguen entre mayúsculas y minúsculas. Puede desactivar 
    | esta opción para su aplicación si es necesario.
    |
    */

    'lowercase_usernames' => true,

    /*
    |--------------------------------------------------------------------------
    | Ruta de inicio
    |--------------------------------------------------------------------------
    |
    | Aquí puede configurar la ruta a la que se redirigirá a los usuarios durante
    | la autenticación o el restablecimiento de contraseña cuando las operaciones tengan éxito
    | y el usuario esté autenticado. Puede modificar este valor libremente.
    |
    */

    'home' => '/dashboard',

    /*
    |--------------------------------------------------------------------------
    | Prefijo/Subdominio de rutas de Fortify
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar qué prefijo asignará Fortify a todas las rutas
    | que registre en la aplicación. Si es necesario, puedes cambiar
    | el subdominio bajo el cual estarán disponibles todas las rutas de Fortify.
    |
    */

    'prefix' => '',

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Fortify Routes Middleware
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar qué middleware asignará Fortify a las rutas
    | que registra en la aplicación. Si es necesario, puedes cambiar
    | estos middleware, pero por lo general se prefiere la opción predeterminada 
    | proporcionada.
    |
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Tasa de Limitación 
    |--------------------------------------------------------------------------
    |
    | Por defecto, Fortify limitará los inicios de sesión a cinco solicitudes por minuto para
    | cada combinación de dirección de correo electrónico y dirección IP. Sin embargo, si deseas
    | especificar un limitador de tasa personalizado, puedes hacerlo aquí.
    |
    */

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    /*
    |--------------------------------------------------------------------------
    | Registrarse / Ver rutas
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar si se deben deshabilitar las rutas que devuelven vistas,
    | ya que es posible que no las necesites al desarrollar tu propia aplicación. 
    | Esto puede ser especialmente cierto si estás creando una aplicación de página
    | única (SPA) personalizada.
    |
    */

    'views' => true,

    /*
    |--------------------------------------------------------------------------
    | Características
    |--------------------------------------------------------------------------
    |
    | Algunas de las funcionalidades de Fortify son opcionales. Puedes deshabilitarlas
    | eliminándolas de este array. Puedes optar por eliminar solo algunas de
    | estas funcionalidades o incluso eliminarlas todas si lo necesitas.
    |
    */

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        // Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
            // 'window' => 0,
        ]),
    ],

];
