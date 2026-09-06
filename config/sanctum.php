<?php

use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | Stateful Domains
    |--------------------------------------------------------------------------
    |
    | Las solicitudes provenientes de los siguientes dominios u hosts recibirán cookies de autenticación de API con estado.
    | Por lo general, estos deben incluir sus dominios locales y de producción
    | que acceden a la API a través de una SPA (Single Page Application) de frontend.
    |
    */

    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        Sanctum::currentApplicationUrlWithPort()
    ))),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards
    |--------------------------------------------------------------------------
    |
    | Este array contiene los *guards* de autenticación que se verificarán cuando
    | Sanctum intente autenticar una solicitud. Si ninguno de estos *guards*
    | logra autenticar la solicitud, Sanctum utilizará el *bearer token*
    | presente en la solicitud entrante para la autenticación.
    |
    */

    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | Este valor controla el número de minutos que deben transcurrir para que un token emitido se considere caducado.
    | Esto prevalecerá sobre cualquier valor establecido en el atributo "expires_at" del token,
    | pero las sesiones de origen propio (first-party sessions) no se verán afectadas.
    |
    */

    'expiration' => null,

    /*
    |--------------------------------------------------------------------------
    | Token Prefix
    |--------------------------------------------------------------------------
    |
    | Sanctum puede añadir un prefijo a los nuevos tokens para aprovechar las numerosas
    | iniciativas de escaneo de seguridad mantenidas por plataformas de código abierto
    | que notifican a los desarrolladores si confirman tokens en repositorios.
    |
    | See: https://docs.github.com/en/code-security/secret-scanning/about-secret-scanning
    |
    */

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Middleware
    |--------------------------------------------------------------------------
    |
    | Al autenticar tu SPA de origen (first-party) con Sanctum, es posible que necesites
    | personalizar algunos de los middlewares que Sanctum utiliza al procesar la
    | solicitud. Puedes modificar los middlewares listados a continuación según sea necesario.
    |
    */

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],

];
