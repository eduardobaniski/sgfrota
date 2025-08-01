<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return "Painel de administração";
})->middleware('admin'); // Middleware para verificar se o usuário é admin

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/logout', [UserController::class, 'logout']);
