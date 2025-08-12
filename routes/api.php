<?php

use App\Models\Marca;
use App\Models\State;
use App\Models\Caminhao;
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
                            ->whereNull('data_fim')
                            ->with(['cidadeOrigem.state', 'cidadeDestino.state'])
                            ->first();

    // 2. Se uma viagem ativa for encontrada...
    if ($viagemAtiva) {
        // 3. Prepara os dados para a resposta, formatando a origem e o destino.
        $dadosResposta = [
            'id' => $viagemAtiva->id,
            'data_inicio' => $viagemAtiva->data_inicio,
            'origem_formatada' => $viagemAtiva->cidadeOrigem->name . ' - ' . $viagemAtiva->cidadeOrigem->state->abbr,
            'destino_formatado' => $viagemAtiva->cidadeDestino->name . ' - ' . $viagemAtiva->cidadeDestino->state->abbr,
        ];
        
        return response()->json($dadosResposta);
    }

    // Se não houver nenhuma viagem ativa, retorna um erro 404.
    return response()->json(['message' => 'Nenhuma viagem ativa encontrada para este caminhão.'], 404);
});