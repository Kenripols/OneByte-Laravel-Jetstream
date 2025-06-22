<?php

use App\Http\Controllers\Admin\BreedController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetController;
use App\Models\Pet;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

//Rutas de usuario con autenticacion y verificacion de rol owner/dueño
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
        Route::resource('pets', PetController::class)
    ->parameters(['pets' => 'pet'])
    ->names('pets');

    Route::get('/', function () {
   return view('dashboard');
})->name('owner.dashboard');
    });

