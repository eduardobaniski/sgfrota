<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\CaminhaoController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', function () {
    return view("auth.login");
});

require __DIR__.'/admin.php';


require __DIR__.'/auth.php';

Route::prefix('api')->group(function () {
    require __DIR__.'/api.php';
});
/*
 *  Rotas para login
*/


Route::post('/login', [UserController::class, 'login']);
Route::get('/perfil', [UserController::class, 'profile']);
Route::put('/perfil', [UserController::class, 'updateProfile'])->name('profile.update');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/logout', [UserController::class, 'logout']);
