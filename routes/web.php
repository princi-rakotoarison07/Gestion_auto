<?php

use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\VenteController;
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
Route::post('/modeles/ajax', [VehiculeController::class, 'storeModeleAjax']);

Route::get('/ventes', [VenteController::class, 'index'])->name('ventes.index');
Route::get('/ventes/create', [VenteController::class, 'create'])->name('ventes.create');
Route::post('/ventes', [VenteController::class, 'store'])->name('ventes.store');
Route::post('/clients/ajax', [VenteController::class, 'storeClientAjax']);
