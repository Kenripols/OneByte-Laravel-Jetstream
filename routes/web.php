<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

// Inicio de agregado 16-12-25
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});