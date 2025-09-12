<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\ViagemController;
use App\Http\Controllers\CaminhaoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\CaminhaoViagemController;
use App\Http\Controllers\AbastecimentoController;


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

    Route::get('/{caminhao}/viagens', [CaminhaoViagemController::class, 'index'])->name('viagens.index');
});


Route::middleware(['auth'])->prefix('viagens')->name('viagens.')->group(function () {
    Route::get('novo/{caminhao}', [ViagemController::class, 'create'])->name('create');
    Route::post('/', [ViagemController::class, 'store'])->name('store');

    Route::get('/{viagem}/editar', [ViagemController::class, 'edit'])->name('edit');
    Route::put('/{viagem}', [ViagemController::class, 'update'])->name('update');
    Route::delete('/{viagem}', [ViagemController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->prefix('motoristas')->name('motorista.')->group(function () {
    Route::get('/', [MotoristaController::class, 'index'])->name('index');
    Route::get('/novo', [MotoristaController::class, 'create'])->name('create');

    Route::post('/novo', [MotoristaController::class, 'store'])->name('store');
    Route::get('/{motorista}/editar', [MotoristaController::class, 'edit'])->name('edit');

    Route::put('/{motorista}', [MotoristaController::class, 'update'])->name('update');
    Route::delete('/{motorista}', [MotoristaController::class, 'destroy'])->name('destroy');
});

// Abastecimentos
Route::middleware(['auth'])->prefix('abastecimentos')->name('abastecimentos.')->group(function () {
    Route::get('/', [AbastecimentoController::class, 'index'])->name('index');
    Route::get('/stats', [AbastecimentoController::class, 'stats'])->name('stats');

    // criação
    Route::get('/novo', [AbastecimentoController::class, 'create'])->name('create');
    Route::post('/', [AbastecimentoController::class, 'store'])->name('store');

    // filtros por caminhão/viagem
    Route::get('/caminhao/{caminhao_id}', [AbastecimentoController::class, 'index'])->name('caminhao');
    Route::get('/viagem/{viagem_id}', [AbastecimentoController::class, 'index'])->name('viagem');

    // visualizar/editar/deletar
    Route::get('/{abastecimento}', [AbastecimentoController::class, 'show'])->name('show');
    Route::get('/{abastecimento}/editar', [AbastecimentoController::class, 'edit'])->name('edit');
    Route::put('/{abastecimento}', [AbastecimentoController::class, 'update'])->name('update');
    Route::delete('/{abastecimento}', [AbastecimentoController::class, 'destroy'])->name('destroy');
});
