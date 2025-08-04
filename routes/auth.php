<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\CaminhaoController;
use App\Http\Controllers\DashboardController;


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $caminhoes = CaminhaoController::index();
        return view('dashboard', ['caminhoes' => $caminhoes]);
    })->name('dashboard');
});


Route::middleware(['auth'])->prefix('cadastro')->name('cadastro.')->group(function () {
    Route::get('/', function () {
        return view('cadastro.index');
    })->name('index');

    Route::get('/marca', [MarcaController::class, 'create'])->name('marca.create');
    Route::post('/marca', [MarcaController::class, 'store'])->name('marca.store');

    Route::get('/modelo', [ModeloController::class, 'create'])->name('modelo.create');
    Route::post('/modelo', [ModeloController::class, 'store'])->name('modelo.store');

    Route::get('/user', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
});
