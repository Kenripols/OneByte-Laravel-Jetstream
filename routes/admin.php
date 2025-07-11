<?php

use App\Http\Controllers\Admin\BreedController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetController;
use App\Models\Pet;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

//Rutas de administracion con autenticacion y verificacion de rol admin

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Ruta para la vista de confirmación de borrado (drop)
    Route::get('breeds/{breed}/drop', [BreedController::class, 'drop'])->name('breeds.drop');

    Route::resource('breeds', BreedController::class)
        ->parameters(['breeds' => 'breed'])
        ->names('breeds');

    Route::resource('users', UserController::class)
    ->parameters(['users' => 'user'])
    ->names('users');

    Route::resource('pets', PetController::class)
    ->parameters(['pets' => 'pet'])
    ->names('pets');

    Route::get('/', function () {
   return view('dashboard');
})->name('dashboard');
});


