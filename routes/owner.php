<?php

use App\Http\Controllers\Owner\PetController;
use App\Http\Controllers\Owner\QRPlateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\DashboardController;
//Rutas de usuario con autenticacion y verificacion de rol owner/dueño
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
        Route::resource('pets', PetController::class)
    ->parameters(['pets' => 'pet'])
    ->names('pets');

    Route::resource('QRPlates', QRPlateController::class)->parameters(['QRPlates' => 'QRPlate'])->names('qrplates');    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');   
});

