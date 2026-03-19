<?php

use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetController;
=======
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QRPlateController;
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

    // Rutas admin (solo usuarios con rol admin)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        // Usuarios
        Route::get('users/{user}/confirm-delete', [UserController::class, 'confirmDelete'])->name('users.confirm-delete');
        Route::get('users/{user}/confirm-force-delete', [UserController::class, 'confirmForceDelete'])->name('users.confirm-force-delete');
        Route::delete('users/{user}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
        Route::get('users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
        Route::patch('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::resource('users', UserController::class);

        // Mascotas (Pets)
        Route::resource('pets', PetController::class);
    });

    // Rutas owner (solo usuarios con rol owner)
    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::resource('pets', PetController::class);
    });

});
=======
// Inicio de agregado 16-12-25
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
//estimo esto va aca adentro, pero vos sos el que sabe de rutas
    Route::post('/admin/qrplates/generate',[QRPlateController::class,'generate'])->name('admin.qrplates.generate');

     Route::post('qrplates/download', [QRPlateController::class, 'download'])->name('admin.qrplates.download');
});

//
>>>>>>> Stashed changes
