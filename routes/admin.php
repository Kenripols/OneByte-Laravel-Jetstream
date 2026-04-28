<?php

use App\Http\Controllers\Admin\BreedController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\QRPlateController;
use Illuminate\Support\Facades\Route;

// Rutas de administracion con autenticacion y verificacion de rol admin
// Rutas de admin manejo de usuarios movidas 14-3-2026
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Ruta para la vista de confirmación de borrado (drop)
    Route::get('breeds/{breed}/drop', [BreedController::class, 'drop'])->name('breeds.drop');
    Route::resource('breeds', BreedController::class)
        ->parameters(['breeds' => 'breed'])
        ->names('breeds');

    // Users
    Route::get('users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
    Route::patch('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::get('users/{user}/confirm-delete', [UserController::class, 'confirmDelete'])->name('users.confirm-delete');
    Route::get('users/{user}/confirm-force-delete', [UserController::class, 'confirmForceDelete'])->name('users.confirm-force-delete');
    Route::delete('users/{user}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
    Route::resource('users', UserController::class)
        ->parameters(['users' => 'user'])
        ->names('users');

    // Rutas para mascotas, limito el acceso unicamente a index y show, las demás acciones se manejarán con Livewire y modal
    Route::resource('pets', PetController::class)
    ->only(['index', 'show'])
    ->parameters(['pets' => 'pet'])
    ->names('pets');
    //Rutas para placas QR admin
    Route::post('qrplates/generate',[QRPlateController::class,'generate'])->name('qrplates.generate');
    Route::post('qrplates/download', [QRPlateController::class, 'download'])->name('qrplates.download');
    Route::resource('qrplates', QRPlateController::class)
    ->only(['index', 'show'])
    ->names('qrplates');
});


