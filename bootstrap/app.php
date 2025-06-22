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
            //Aclaro que archivo almacena las rutas de administracion    
            ->group(__DIR__.'/../routes/admin.php');
            //Aclaro que archivo almacena las rutas de owner/dueño
            Route::middleware('web', 'auth:sanctum', config('jetstream.auth_session'))
            ->group(__DIR__.'/../routes/owner.php');
            
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Agrego alias para los middlewares de Spatie Permission
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
