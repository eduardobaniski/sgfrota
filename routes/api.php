<?php

use App\Models\Marca;
use App\Models\State;
use App\Models\Caminhao;
use App\Models\City;
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

Route::get('/caminhoes/{caminhao}/viagem-ativa', function (Caminhao $caminhao) {
    // 1. Busca a viagem ativa e já carrega os relacionamentos necessários
    //    para evitar múltiplas queries (Eager Loading).
    $viagemAtiva = $caminhao->viagens()
                            ->whereNull('dataFim') // Use o nome da coluna em camelCase
                            ->with(['origem.state', 'destino.state'])
                            ->first();

    // 2. Se uma viagem ativa for encontrada...
    if ($viagemAtiva) {
        // 3. Prepara os dados para a resposta, formatando a origem e o destino.
        $dadosResposta = [
            'id' => $viagemAtiva->id,
            'dataInicio' => $viagemAtiva->dataInicio,
            'odometroInicio' => $viagemAtiva->odometroInicio,
            'origem' => $viagemAtiva->origem->name . ' - ' . $viagemAtiva->origem->state->name,
            'origemId' => [
                'cidadeId' => $viagemAtiva->origem->id, 
                'stateId' => $viagemAtiva->origem->state->id
            ],
            'destino' => $viagemAtiva->destino->name . ' - ' . $viagemAtiva->destino->state->name,
            'destinoId' => [
                'cidadeId' => $viagemAtiva->destino->id, 
                'stateId' => $viagemAtiva->destino->state->id
            ],
        ];
        
        return response()->json($dadosResposta);
    }

    // Se não houver nenhuma viagem ativa, retorna um erro 404.
    return response()->json(['message' => 'Nenhuma viagem ativa encontrada para este caminhão.'], 404);
});

Route::get('/abastecimentos/stats', [AbastecimentoController::class, 'stats']);
Route::apiResource('abastecimentos', AbastecimentoController::class);