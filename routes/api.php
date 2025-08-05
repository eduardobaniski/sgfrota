<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Marca;

/*
|--------------------------------------------------------------------------
| Rotas da API
|--------------------------------------------------------------------------
|
| Aqui é onde pode registar as rotas da API para a sua aplicação. Estas
| rotas são carregadas pelo RouteServiceProvider e recebem
| automaticamente o prefixo de URL /api.
|
*/


Route::get('/marcas/{marca}/modelos', function (Marca $marca) {
    return response()->json($marca->modelos()->orderBy('nome')->get());
});
