<?php

use App\Http\Controllers\Admin\BreedController;
use illuminate\Support\Facades\Route;


Route::resource('breeds', BreedController::class)
    ->parameters(['breeds' => 'breed'])
    ->names('admin.breeds');

Route::get('/', function () {
   return view('dashboard');
})->name('admin.dashboard');

Route::get('/users', function () {
   // return view('admin.users');
   return "Hola Admin Users";
})->name('admin.users');
