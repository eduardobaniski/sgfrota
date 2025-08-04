<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', function () {
    return view("auth.login");
});


Route::middleware(['auth'])->group(function () {
    #Rotas aqui são protegidas por autenticação
    
    Route::get('/dashboard', function () {
         $caminhoes = [
        (object)['modelo'=>'teste', 'placa' => 'ABC-1234', 'status' => 'Em Trânsito', /* ... */],
        (object)['modelo'=>'teste','placa' => 'DEF-5678', 'status' => 'Disponível', /* ... */],
        // ... outros caminhões
    ];
        return view('dashboard', ['caminhoes' => $caminhoes]);
    })->name('dashboard');


});

Route::get('/adminPanel', function () {
    return view('admin.home');
})->middleware('admin'); // Middleware para verificar se o usuário é admin

Route::middleware(['admin'])->prefix('cadastro')->name('cadastro.')->group(function () {
    Route::get('/', function () {
        return view('cadastro.index');
    })->name('index');

    Route::get('/marca', [MarcaController::class, 'index'])->name('marca.index');
    Route::post('/marca', [MarcaController::class, 'store'])->name('marca.store');

    Route::get('/modelo', [ModeloController::class, 'index'])->name('modelo.index');
    Route::post('/modelo', [ModeloController::class, 'store'])->name('modelo.store');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/logout', [UserController::class, 'logout']);
