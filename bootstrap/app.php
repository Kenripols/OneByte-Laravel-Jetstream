<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        //Agrego nuevas rutas con prequisito de token y autenticacion
        then: function() {
            Route::middleware('web', 'auth:sanctum', config('jetstream.auth_session'))
            //Prefijo admin para las rutas
            ->prefix('admin')    
            ->group(__DIR__.'/../routes/admin.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
