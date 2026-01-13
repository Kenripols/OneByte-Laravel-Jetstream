<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\DashboardController; // Agregado 16-12-25
>>>>>>> Stashed changes

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
<<<<<<< Updated upstream
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
=======
    
    // Inicio de agregado 16-12-25
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    // Final de agregado 16-12-25

    // Route::get('/dashboard', function () { //Comentado 16-12-25
    //     return view('dashboard'); //Comentado 16-12-25
    // })->name('dashboard'); //Comentado 16-12-25
//Ver de mover las rutas admin a routes/admin.php
    // Rutas admin (solo usuarios con rol admin)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        // Usuarios
        Route::get('users/{user}/confirm-delete', [UserController::class, 'confirmDelete'])->name('users.confirm-delete');
        Route::get('users/{user}/confirm-force-delete', [UserController::class, 'confirmForceDelete'])->name('users.confirm-force-delete');
        Route::delete('users/{user}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
        Route::get('users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
        Route::patch('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::resource('users', UserController::class);
>>>>>>> Stashed changes

// Estas rutas deberian estar en routes/admin.php que es el archivo donde se guardan las rutas de admin
// Rutas admin agrupadas con prefijo y nombre 'admin.'
Route::prefix('admin')->name('admin.')->group(function () {

    // Confirmación de borrado lógico
    Route::get('users/{user}/confirm-delete', [UserController::class, 'confirmDelete'])->name('users.confirm-delete');

    // Confirmación de borrado físico
    Route::get('users/{user}/confirm-force-delete', [UserController::class, 'confirmForceDelete'])->name('users.confirm-force-delete');

    // Borrado físico (force delete)
    Route::delete('users/{user}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
    
    Route::get('users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
    Route::patch('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    
    // CRUD completo para users
    Route::resource('users', UserController::class);
});

