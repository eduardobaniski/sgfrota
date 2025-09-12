<?php

namespace App\Http\Controllers;

use App\Models\Abastecimento;
use Illuminate\Http\Request;

class AbastecimentoController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['caminhao_id', 'viagem_id', 'data_inicio', 'data_fim']);
        $perPage = $request->integer('per_page', 15);

        $query = Abastecimento::with(['caminhao', 'viagem.motorista'])
            ->filter($filters)
            ->latest('data');

        $items = $query->paginate($perPage)->appends($request->query());

        $caminhao = isset($filters['caminhao_id']) ? \App\Models\Caminhao::find($filters['caminhao_id']) : null;
        $viagem = isset($filters['viagem_id']) ? \App\Models\Viagem::find($filters['viagem_id']) : null;

        return view('abastecimentos.index', compact('items', 'filters', 'caminhao', 'viagem'));
    }

    public function show(Abastecimento $abastecimento)
    {
        $abastecimento->load(['caminhao', 'viagem.motorista']);
        return view('abastecimentos.show', compact('abastecimento'));
    }

    public function create(Request $request)
    {
        $defaults = $request->only(['caminhao_id', 'viagem_id', 'data']);
        return view('abastecimentos.create', compact('defaults'));
    }

    public function edit(Abastecimento $abastecimento)
    {
        $abastecimento->load(['caminhao', 'viagem.motorista']);
        return view('abastecimentos.edit', compact('abastecimento'));
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'caminhao_id',
            'viagem_id',
            'data',
            'odometro',
            'litros',
            'preco_por_litro',
            'valor_total',
            'observacoes',
        ]);

        if (!isset($data['valor_total']) && isset($data['litros'], $data['preco_por_litro'])) {
            $data['valor_total'] = number_format((float)$data['litros'] * (float)$data['preco_por_litro'], 2, '.', '');
        }

        $abastecimento = Abastecimento::create($data);
        return redirect()->route('abastecimentos.index', [
            'viagem_id' => $abastecimento->viagem_id,
        ])->with('success', 'Abastecimento criado com sucesso.');
    }

    public function update(Request $request, Abastecimento $abastecimento)
    {
        $data = $request->only([
            'caminhao_id',
            'viagem_id',
            'data',
            'odometro',
            'litros',
            'preco_por_litro',
            'valor_total',
            'observacoes',
        ]);

        if (!isset($data['valor_total'])) {
            $litros = $data['litros'] ?? $abastecimento->litros;
            $preco  = $data['preco_por_litro'] ?? $abastecimento->preco_por_litro;
            if ($litros !== null && $preco !== null) {
                $data['valor_total'] = number_format((float)$litros * (float)$preco, 2, '.', '');
            }
        }

        $abastecimento->update($data);
        return redirect()->route('abastecimentos.index', [
            'viagem_id' => $abastecimento->viagem_id,
        ])->with('success', 'Abastecimento atualizado com sucesso.');
    }

    public function destroy(Abastecimento $abastecimento)
    {
        $viagemId = $abastecimento->viagem_id;
        $abastecimento->delete();
        return redirect()->route('abastecimentos.index', [
            'viagem_id' => $viagemId,
        ])->with('success', 'Abastecimento removido com sucesso.');
    }

    public function stats(Request $request)
    {
        $filters = $request->only(['caminhao_id', 'viagem_id', 'data_inicio', 'data_fim']);
        $query = Abastecimento::filter($filters);

        $totals = (clone $query)->selectRaw('
                COALESCE(SUM(litros),0) as total_litros,
                COALESCE(SUM(valor_total),0) as total_gasto,
                COUNT(*) as abastecimentos
            ')->first();

        $media_preco = (clone $query)->whereNotNull('preco_por_litro')->avg('preco_por_litro');

        $por_mes = (clone $query)
            ->selectRaw("strftime('%Y-%m', data) as ano_mes, COALESCE(SUM(valor_total),0) as total_gasto, COALESCE(SUM(litros),0) as total_litros, COUNT(*) as qtd")
            ->groupBy('ano_mes')
            ->orderBy('ano_mes')
            ->get();

        $summary = [
            'total_litros' => (float) ($totals->total_litros ?? 0),
            'total_gasto' => (float) ($totals->total_gasto ?? 0),
            'abastecimentos' => (int) ($totals->abastecimentos ?? 0),
            'media_preco_por_litro' => $media_preco !== null ? (float) $media_preco : null,
        ];

        return view('abastecimentos.stats', compact('summary', 'por_mes', 'filters'));
    }
}
