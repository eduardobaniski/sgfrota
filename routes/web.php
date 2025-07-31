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
        return view('app');
    })->name('dashboard');


});

Route::get('/adminPanel', function () {
    return "Painel de administração";
})->middleware('admin'); // Middleware para verificar se o usuário é admin

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/logout', [UserController::class, 'logout']);
