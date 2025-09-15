<?php

namespace App\Http\Controllers;

use App\Models\Caminhao;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard', ['caminhoes' => Caminhao::all()]);
    }
}
$totais = \App\Models\Abastecimento::selectRaw(
    'COALESCE(SUM(litros),0) as total_litros, COALESCE(SUM(valor_total),0) as total_gasto, COUNT(*) as qtd, MAX("data") as last_data'
)
->where('caminhao_id', $caminhaoId)
->first();
