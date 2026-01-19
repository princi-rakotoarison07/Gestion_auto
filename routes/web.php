<?php

use App\Http\Controllers\VehiculeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/vehicules', [VehiculeController::class, 'index']);
Route::get('/vehicules/create', [VehiculeController::class, 'create']);
Route::post('/vehicules', [VehiculeController::class, 'store']);
