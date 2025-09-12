<?php

namespace App\Http\Controllers;

use App\Models\Caminhao;
use App\Models\Abastecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaminhoesConsumoGeralController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['data_inicio', 'data_fim']);

        $sub = Abastecimento::select('caminhao_id')
            ->selectRaw('COALESCE(SUM(litros),0) as total_litros')
            ->selectRaw('COALESCE(SUM(valor_total),0) as total_gasto')
            ->selectRaw('COUNT(*) as abastecimentos')
            ->when(!empty($filters['data_inicio']), fn($q) => $q->whereDate('data', '>=', $filters['data_inicio']))
            ->when(!empty($filters['data_fim']), fn($q) => $q->whereDate('data', '<=', $filters['data_fim']))
            ->groupBy('caminhao_id');

        $driver = DB::getDriverName();
        $concatExpr = $driver === 'mysql'
            ? "CONCAT(COALESCE(marcas.marca,''), ' ', COALESCE(modelos.modelo,''))"
            : "(COALESCE(marcas.marca,'') || ' ' || COALESCE(modelos.modelo,''))"; // sqlite/pgsql

        $caminhoes = Caminhao::query()
            ->leftJoinSub($sub, 'agg', 'agg.caminhao_id', '=', 'caminhoes.id')
            ->leftJoin('modelos', 'modelos.id', '=', 'caminhoes.modelo_id')
            ->leftJoin('marcas', 'marcas.id', '=', 'modelos.marca_id')
            ->select('caminhoes.*')
            ->selectRaw('COALESCE(agg.total_litros,0) as total_litros')
            ->selectRaw('COALESCE(agg.total_gasto,0) as total_gasto')
            ->selectRaw('COALESCE(agg.abastecimentos,0) as abastecimentos')
            ->addSelect(DB::raw("$concatExpr as modelo_nome"))
            ->orderBy('placa')
            ->paginate(15)
            ->withQueryString();

        return view('caminhoes.consumos.geral', compact('caminhoes', 'filters'));
    }
}
