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

/*
 * Rotas de cadastro 
*/
// Route::middleware(['auth'])->prefix('cadastro')->name('cadastro.user.')->group(function () {
//     Route::get('/', function () {
//         return view('cadastro.index');
//     })->name('index');

//     Route::get('/caminhao', [CaminhaoController::class, 'create'])->name('caminhao.create');
//     Route::post('/caminhao', [CaminhaoController::class, 'store'])->name('caminhao.store');

// });
