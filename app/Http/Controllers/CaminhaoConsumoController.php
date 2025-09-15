<?php

namespace App\Http\Controllers;

use App\Models\Caminhao;
use App\Models\Abastecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CaminhaoConsumoController extends Controller
{
    public function index(Caminhao $caminhao, Request $request)
    {
        $filters = $request->only(['data_inicio', 'data_fim', 'viagem_id']);

        // Base sem ordenação para evitar erros de GROUP BY nas agregações
        $baseQuery = Abastecimento::with(['viagem.motorista'])
            ->where('caminhao_id', $caminhao->id);

        if (!empty($filters['data_inicio'])) {
            $baseQuery->whereDate('data', '>=', $filters['data_inicio']);
        }
        if (!empty($filters['data_fim'])) {
            $baseQuery->whereDate('data', '<=', $filters['data_fim']);
        }
        if (!empty($filters['viagem_id'])) {
            $baseQuery->where('viagem_id', $filters['viagem_id']);
        }

        // Ordenação aplicada apenas na listagem/paginação
        $items = (clone $baseQuery)
            ->orderByDesc('data')
            ->paginate(15)
            ->withQueryString();

        // Agregações sem ORDER BY
        $agg = (clone $baseQuery)
            ->selectRaw('COALESCE(SUM(litros),0) as total_litros, COALESCE(SUM(valor_total),0) as total_gasto, COUNT(*) as qtd')
            ->first();

        $preco_medio = (clone $baseQuery)->whereNotNull('preco_por_litro')->avg('preco_por_litro');
        $min_odo = (clone $baseQuery)->whereNotNull('odometro')->min('odometro');
        $max_odo = (clone $baseQuery)->whereNotNull('odometro')->max('odometro');
        $km_rodados = ($min_odo !== null && $max_odo !== null && $max_odo >= $min_odo) ? ($max_odo - $min_odo) : null;
        $consumo_medio = ($km_rodados && $agg && $agg->total_litros > 0) ? ($km_rodados / $agg->total_litros) : null;

        $kpi = [
            'total_litros' => (float) ($agg->total_litros ?? 0),
            'total_gasto' => (float) ($agg->total_gasto ?? 0),
            'media_preco_por_litro' => $preco_medio ? (float) $preco_medio : null,
            'km_rodados' => $km_rodados,
            'consumo_km_l' => $consumo_medio,
        ];

        return view('caminhoes.consumos.index', compact('caminhao', 'items', 'filters', 'kpi'));
    }

    public function stats(Caminhao $caminhao, Request $request)
    {
        $filters = $request->only(['data_inicio', 'data_fim', 'viagem_id']);

        $query = Abastecimento::where('caminhao_id', $caminhao->id);
        if (!empty($filters['data_inicio'])) $query->whereDate('data', '>=', $filters['data_inicio']);
        if (!empty($filters['data_fim'])) $query->whereDate('data', '<=', $filters['data_fim']);
        if (!empty($filters['viagem_id'])) $query->where('viagem_id', $filters['viagem_id']);

        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            $periodExpr = "strftime('%Y-%m', data)";
        } elseif ($driver === 'mysql') {
            $periodExpr = "DATE_FORMAT(data, '%Y-%m')";
        } else { // pgsql e outros
            $periodExpr = "to_char(data, 'YYYY-MM')";
        }

        $rows = $query
            ->selectRaw("{$periodExpr} as periodo, COALESCE(SUM(valor_total),0) as total_gasto, COALESCE(SUM(litros),0) as total_litros, COUNT(*) as abastecimentos")
            ->groupBy('periodo')
            ->orderBy('periodo')
            ->get();

        return response()->json($rows);
    }

    public function export(Caminhao $caminhao, string $format, Request $request)
    {
        $filters = $request->only(['data_inicio', 'data_fim', 'viagem_id']);

        // Base sem ordenação para evitar conflitos nas agregações
        $baseQuery = Abastecimento::with(['viagem.motorista'])
            ->where('caminhao_id', $caminhao->id);

        if (!empty($filters['data_inicio'])) $baseQuery->whereDate('data', '>=', $filters['data_inicio']);
        if (!empty($filters['data_fim'])) $baseQuery->whereDate('data', '<=', $filters['data_fim']);
        if (!empty($filters['viagem_id'])) $baseQuery->where('viagem_id', $filters['viagem_id']);

        if ($format === 'csv') {
            $response = new StreamedResponse(function () use ($baseQuery) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Data', 'Litros', 'Preço/L', 'Total', 'Viagem', 'Motorista']);

                // Ordene apenas para a exportação de linhas
                (clone $baseQuery)->orderBy('data')->chunk(500, function ($chunk) use ($handle) {
                    foreach ($chunk as $a) {
                        fputcsv($handle, [
                            optional($a->data)->format('Y-m-d') ?? $a->data,
                            (float) $a->litros,
                            $a->preco_por_litro !== null ? (float) $a->preco_por_litro : null,
                            $a->valor_total !== null ? (float) $a->valor_total : null,
                            $a->viagem_id,
                            optional(optional($a->viagem)->motorista)->nome,
                        ]);
                    }
                });

                fclose($handle);
            });
            $filename = 'consumo_'.$caminhao->placa.'_'.now()->format('Ymd_His').'.csv';
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}\"");
            return $response;
        }

        if ($format === 'pdf') {
            $items = (clone $baseQuery)->orderBy('data')->get();

            // Agregações a partir da base sem ORDER BY
            $agg = (clone $baseQuery)->selectRaw('COALESCE(SUM(litros),0) as total_litros, COALESCE(SUM(valor_total),0) as total_gasto')->first();
            $preco_medio = (clone $baseQuery)->whereNotNull('preco_por_litro')->avg('preco_por_litro');
            $min_odo = (clone $baseQuery)->whereNotNull('odometro')->min('odometro');
            $max_odo = (clone $baseQuery)->whereNotNull('odometro')->max('odometro');
            $km_rodados = ($min_odo !== null && $max_odo !== null && $max_odo >= $min_odo) ? ($max_odo - $min_odo) : null;
            $consumo_medio = ($km_rodados && ($agg->total_litros ?? 0) > 0) ? ($km_rodados / $agg->total_litros) : null;

            $kpi = [
                'total_litros' => (float) ($agg->total_litros ?? 0),
                'total_gasto' => (float) ($agg->total_gasto ?? 0),
                'media_preco_por_litro' => $preco_medio ? (float) $preco_medio : null,
                'km_rodados' => $km_rodados,
                'consumo_km_l' => $consumo_medio,
            ];

            $view = view('caminhoes.consumos.pdf', compact('caminhao', 'items', 'filters', 'kpi'))->render();

            if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($view)->setPaper('a4', 'portrait');
                $filename = 'consumo_'.$caminhao->placa.'_'.now()->format('Ymd_His').'.pdf';
                return $pdf->download($filename);
            }
            if (app()->bound('dompdf.wrapper')) {
                $pdf = app('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('a4', 'portrait');
                $filename = 'consumo_'.$caminhao->placa.'_'.now()->format('Ymd_His').'.pdf';
                return $pdf->download($filename);
            }

            return back()->with('error', 'Exportação em PDF requer barryvdh/laravel-dompdf. Instale o pacote para continuar.');
        }

        return back()->with('error', 'Formato de exportação não suportado.');
    }
}
