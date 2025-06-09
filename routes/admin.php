<?php

use App\Http\Controllers\Admin\BreedController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetController;
use App\Models\Pet;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;


Route::resource('breeds', BreedController::class)
    ->parameters(['breeds' => 'breed'])
    ->names('admin.breeds');

Route::resource('users', UserController::class)
    ->parameters(['users' => 'user'])
    ->names('admin.users');

Route::resource('pets', PetController::class)
    ->parameters(['pets' => 'pet'])
    ->names('admin.pets');
      

Route::get('/', function () {
   return view('dashboard');
})->name('admin.dashboard');


