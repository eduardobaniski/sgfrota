<?php

use App\Models\Marca;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/estados/{state}/cidades', function (State $state) {
    // Graças ao Route Model Binding, o Laravel já encontra o estado pelo ID.
    // Usamos o relacionamento 'cities()' que definimos no modelo State.
    return response()->json($state->cities()->orderBy('name')->get());
});
