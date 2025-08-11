<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\ViagemController;
use App\Http\Controllers\CaminhaoController;
use App\Http\Controllers\DashboardController;


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $caminhoes = CaminhaoController::all();
        return view('dashboard', ['caminhoes' => $caminhoes]);
    })->name('dashboard');
});


Route::middleware(['auth'])->prefix('caminhoes')->name('caminhoes.')->group(function () {
    Route::get('/', [CaminhaoController::class, 'index'])->name('index');
    
    Route::get('/novo', [CaminhaoController::class, 'create'])->name('create');
    Route::post('/', [CaminhaoController::class, 'store'])->name('store');

    Route::get('/{caminhao}/editar', [CaminhaoController::class, 'edit'])->name('edit');
    Route::put('/{caminhao}', [CaminhaoController::class, 'update'])->name('update');

    Route::delete('/{caminhao}', [CaminhaoController::class, 'destroy'])->name('destroy');
});


Route::middleware(['auth'])->prefix('viagens')->name('viagens.')->group(function () {
    Route::get('novo/{caminhao}', [ViagemController::class, 'create'])->name('create');
    Route::post('/', [ViagemController::class, 'store'])->name('store');
});
