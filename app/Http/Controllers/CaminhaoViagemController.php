<?php

namespace App\Http\Controllers;

use App\Models\Caminhao;
use Illuminate\Http\Request;

class CaminhaoViagemController extends Controller
{
    public function index(Caminhao $caminhao)
    {
        // 1. Carrega o caminhão com os seus relacionamentos para exibir na view.
        $caminhao->load('modelo.marca');

        // 2. Busca todas as viagens associadas a este caminhão.
        //    - Usa with() para carregar os dados de origem e destino de forma otimizada.
        //    - Ordena pelas mais recentes (data de início descendente).
        //    - Pagina os resultados para lidar com históricos longos.
        $historicoViagens = $caminhao->viagens()
                                     ->with(['origem.state', 'destino.state'])
                                     ->orderBy('dataInicio', 'desc')
                                     ->paginate(15);

        // 3. Retorna a view, passando os dados do caminhão e o seu histórico de viagens.
        return view('caminhoes.viagens.index', [
            'caminhao' => $caminhao,
            'viagens' => $historicoViagens
        ]);
    }
}
