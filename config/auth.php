<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Valores predeterminados de autenticación
    |--------------------------------------------------------------------------
    |
    | Esta opción define el «guard» de autenticación y el «broker» de restablecimiento
    | de contraseñas predeterminados para tu aplicación. Puedes modificar estos valores
    | según sea necesario, pero constituyen un punto de partida ideal para la mayoría de las aplicaciones.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Guardias de autenticación
    |--------------------------------------------------------------------------
    |
    | A continuación, puedes definir cada guardia de autenticación para tu aplicación.
    | Por supuesto, ya se ha definido una excelente configuración predeterminada
    | que utiliza el almacenamiento de sesiones y el proveedor de usuarios Eloquent.
    |
    | Todos los guardias de autenticación cuentan con un proveedor de usuarios,
    | el cual define cómo se recuperan realmente los usuarios de tu base de datos
    | o del sistema de almacenamiento que utilice la aplicación. Por lo general,
    | se utiliza Eloquent.
    |
    | Compatible con: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Proveedores de usuarios
    |--------------------------------------------------------------------------
    |
    | Todos los guardias de autenticación cuentan con un proveedor de usuarios, el cual define cómo
    | se recuperan realmente los usuarios de tu base de datos o de cualquier otro sistema
    | de almacenamiento utilizado por la aplicación. Por lo general, se emplea Eloquent.
    |
    | Si tienes varias tablas o modelos de usuario, puedes configurar múltiples
    | proveedores para representar dichos modelos o tablas. Posteriormente, estos proveedores
    | pueden asignarse a cualquier guardia de autenticación adicional que hayas definido.
    |
    | Opciones admitidas: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Restablecimiento de contraseñas
    |--------------------------------------------------------------------------
    |
    | Estas opciones de configuración definen el comportamiento de la funcionalidad
    | de restablecimiento de contraseñas de Laravel, incluyendo la tabla utilizada
    | para almacenar los tokens y el proveedor de usuarios invocado para recuperar
    | a los usuarios.
    |
    | El tiempo de expiración es la cantidad de minutos durante los cuales cada
    | token de restablecimiento se considerará válido. Esta medida de seguridad
    | limita la vida útil de los tokens para reducir las probabilidades de que
    | sean adivinados. Puedes modificar este valor según sea necesario.
    |
    | La configuración de limitación de frecuencia (throttle) indica cuántos
    | segundos debe esperar un usuario antes de generar más tokens de
    | restablecimiento de contraseña. Esto evita que el usuario genere
    | rápidamente una gran cantidad de tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tiempo de espera agotado para la confirmación de contraseña
    |--------------------------------------------------------------------------
    |
    |Aquí puede definir la cantidad de segundos antes de que expire la ventana de confirmación de contraseña
    | y se solicite a los usuarios que vuelvan a introducir su contraseña a través de la
    | pantalla de confirmación. Por defecto, el tiempo de espera es de tres horas.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
/*rS94IHkKnH-eaKxg3mufN
WpL3Ojg3xA-b6fGyq41iR
HnQfedYBpx-5bSvUJ1uCD
nDFhSHUvsG-1A1P1zG3hA
MTJpvv4RFf-suaop0mkB9
eikg2Estkp-Sn3qOveQRk
isMS6ygb5C-bDWGVWeO0M
irv05LMpHi-K644Lvj5hm*/