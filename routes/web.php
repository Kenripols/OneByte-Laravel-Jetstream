<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Qr\ScanController;
use App\Http\Controllers\Qr\QrAssignmentController;
use App\Http\Controllers\Owner\QRPlateController;
use App\Http\Controllers\PublicQrController;

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

//Route::get('/qr/{code}', [QrController::class, 'handle']);

Route::get('/qr/assign', [QrAssignmentController::class, 'form'])
    ->name('qr.assign.form');

Route::get('/qr/{code}', [ScanController::class, 'handle']);

Route::get('/qr/{code}/claim', [QRPlateController::class, 'claim'])
    ->middleware('auth')
    ->name('qr.claim');

Route::get('/qr/{code}/resolve', [ScanController::class, 'resolve'])
    ->name('owner.qr.resolve'); //te logueas, te registras, ya estas logueado, etc.

Route::post('/qr/{code}/claim', [QRPlateController::class, 'claim'])
    ->name('owner.qr.claim'); //trancar QR para usaurio

Route::post('/qr/{code}/location', [PublicQrController::class, 'sendLocation'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('qr.sendLocation'); //esta chanchada es porque es publico y tranca