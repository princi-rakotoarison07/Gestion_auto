<?php

use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\PaiementController;
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

Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');
Route::get('/paiements/create', [PaiementController::class, 'create'])->name('paiements.create');
Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');
Route::get('/ventes/{id}/details', [PaiementController::class, 'getVenteDetailsAjax']);
