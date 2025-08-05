<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\CaminhaoController;
use App\Http\Controllers\DashboardController;


Route::get('/adminPanel', function () {
    return view('admin.home');
})->middleware('admin')->name('admin'); // Middleware para verificar se o usuário é admin

/*
 *  Rotas para gerenciar 
*/

Route::middleware(['admin'])->prefix('gerenciar')->name('admin.gerenciar.')->group(function () {
    Route::get('/', function () {
        return view('admin.gerenciar.index');
    })->name('index');

    Route::get('/marca', [MarcaController::class, 'index'])->name('marca.index'); 
    Route::get('/marca/{marca}/editar', [MarcaController::class, 'edit'])->name('marca.edit');
    Route::put('/marca/{marca}', [MarcaController::class, 'update'])->name('marca.update');
    Route::delete('/marca/{marca}', [MarcaController::class, 'destroy'])->name('marca.destroy');


    Route::get('/modelo', [ModeloController::class, 'index'])->name('modelo.index');
    Route::get('/modelo/{modelo}/editar', [ModeloController::class, 'edit'])->name('modelo.edit');
    Route::put('/modelo/{modelo}', [ModeloController::class, 'update'])->name('modelo.update');
    Route::delete('/modelo/{modelo}', [ModeloController::class, 'destroy'])->name('modelo.destroy');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}/editar', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});



/*
 *  Rotas para cadastro
*/


Route::middleware(['admin'])->prefix('cadastro')->name('cadastro.')->group(function () {
    Route::get('/', function () {
        return view('admin.cadastro.index');
    })->name('index');

    Route::get('/marca', [MarcaController::class, 'create'])->name('marca.create');
    Route::post('/marca', [MarcaController::class, 'store'])->name('marca.store');

    Route::get('/modelo', [ModeloController::class, 'create'])->name('modelo.create');
    Route::post('/modelo', [ModeloController::class, 'store'])->name('modelo.store');

    Route::get('/user', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
});
