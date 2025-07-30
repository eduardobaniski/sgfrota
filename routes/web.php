<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view("welcome");
});


Route::middleware(['auth'])->group(function () {
    #Rotas aqui são protegidas por autenticação
    
    Route::get('/dashboard', function () {
        return "dashboard logada";
    });


});

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
