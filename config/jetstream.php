<?php

use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Middleware\AuthenticateSession;

return [

    /*
    |--------------------------------------------------------------------------
    | Jetstream Stack
    |--------------------------------------------------------------------------
    |
    | Este valor de configuración indica a Jetstream qué "stack" utilizarás
    | para tu aplicación. Por lo general, este valor se establece automáticamente
    | durante la instalación y no será necesario modificarlo posteriormente.
    |
    */

    'stack' => 'livewire',

    /*
    |--------------------------------------------------------------------------
    | Jetstream Route Middleware
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar qué middleware asignará Jetstream a las rutas
    | que registra en la aplicación. Cuando sea necesario, puedes modificar
    | estos middleware; sin embargo, este valor predeterminado suele ser suficiente.
    |
    */

    'middleware' => ['web'],

    'auth_session' => AuthenticateSession::class,

    /*
    |--------------------------------------------------------------------------
    | Jetstream Guard
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar el guardián de autenticación que Jetstream utilizará al
    | autenticar a los usuarios. Este valor debe corresponder a uno de los
    | guardianes ya definidos en tu archivo de configuración "auth".
    |
    */

    'guard' => 'sanctum',

    /*
    |--------------------------------------------------------------------------
    | Características
    |--------------------------------------------------------------------------
    |
    | Algunas de las características de Jetstream son opcionales. Puedes deshabilitarlas
    | eliminándolas de este array. Eres libre de eliminar solo algunas de
    | estas características o incluso todas ellas, si lo necesitas.
    |
    */

    'features' => [
        // Features::termsAndPrivacyPolicy(),
        // Features::profilePhotos(),
        // Features::api(),
        // Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Disco de foto de perfil
    |--------------------------------------------------------------------------
    |
    | Este valor de configuración determina el disco predeterminado que se utilizará
    | al almacenar las fotos de perfil de los usuarios de tu aplicación. Por lo general,
    | será el disco "public", pero puedes ajustarlo si es necesario.
    |
    */

    'profile_photo_disk' => 'public',

];
