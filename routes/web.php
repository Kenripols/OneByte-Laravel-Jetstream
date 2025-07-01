<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

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

