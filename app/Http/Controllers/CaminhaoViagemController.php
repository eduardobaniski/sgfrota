<?php

namespace App\Http\Controllers;

use App\Models\Caminhao;
use App\Models\Viagem;
use Illuminate\Http\Request;

class CaminhaoViagemController extends Controller
{
    public function index(Caminhao $caminhao, Request $request)
    {
        // 1. Carrega o caminhão com os seus relacionamentos para exibir na view.
        $caminhao->load('modelo.marca');

        $perPage = $request->integer('per_page', 10);

        // 2. Busca todas as viagens associadas a este caminhão.
        //    - Usa with() para carregar os dados de origem e destino de forma otimizada.
        //    - Ordena pelas mais recentes (data de início descendente).
        //    - Pagina os resultados para lidar com históricos longos.
        $viagens = Viagem::with(['motorista', 'origem.state', 'destino.state'])
                         ->where('caminhao_id', $caminhao->id)
                         ->orderByDesc('dataInicio')
                         ->paginate($perPage)
                         ->withQueryString();

        // 3. Retorna a view, passando os dados do caminhão e o seu histórico de viagens.
        return view('caminhoes.viagens.index', compact('caminhao', 'viagens'));
    }
}
