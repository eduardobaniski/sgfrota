<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">

  <title>Consumo - {{ $caminhao->placa }}</title>
  <style>
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #111; }
    h1 { font-size: 18px; margin: 0 0 8px; }
    h2 { font-size: 14px; margin: 20px 0 8px; }
    .muted { color: #666; }
    .kpis { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
    .kpi { border: 1px solid #ddd; padding: 8px; border-radius: 4px; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    th, td { border: 1px solid #ddd; padding: 6px; }
    th { background: #f5f5f5; text-align: left; }
  </style>
</head>
<body>
  <h1>Relatório de Consumo - Caminhão {{ $caminhao->placa }}</h1>
  {{-- <p class="muted">Período: {{ $filters['data_inicio'] ?? '—' }} a {{ $filters['data_fim'] ?? '—' }} | Viagem: {{ $filters['viagem_id'] ?? '—' }}</p> --}}

  <div class="kpis">
    <div class="kpi"><strong>Total de litros</strong><br>{{ number_format($kpi['total_litros'], 3, ',', '.') }} L</div>
    <div class="kpi"><strong>Gasto total</strong><br>R$ {{ number_format($kpi['total_gasto'], 2, ',', '.') }}</div>
    <div class="kpi"><strong>Preço médio/L</strong><br>{{ $kpi['media_preco_por_litro'] !== null ? 'R$ '.number_format($kpi['media_preco_por_litro'], 3, ',', '.') : '-' }}</div>
    <div class="kpi"><strong>Consumo médio</strong><br>{{ $kpi['consumo_km_l'] !== null ? number_format($kpi['consumo_km_l'], 2, ',', '.') . ' km/L' : '-' }}</div>
  </div>

  <h2>Abastecimentos</h2>
  <table>
    <thead>
      <tr>
        <th>Data</th>
        <th>Litros</th>
        <th>Preço/L</th>
        <th>Total</th>
        <th>Viagem</th>
        <th>Motorista</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $item)
      <tr>
        <td>{{ optional($item->data)->format('Y-m-d') ?? $item->data }}</td>
        <td>{{ number_format((float)$item->litros, 3, ',', '.') }}</td>
        <td>{{ $item->preco_por_litro !== null ? 'R$ '.number_format((float)$item->preco_por_litro, 3, ',', '.') : '-' }}</td>
        <td>{{ $item->valor_total !== null ? 'R$ '.number_format((float)$item->valor_total, 2, ',', '.') : '-' }}</td>
        <td>#{{ $item->viagem_id }}</td>
        <td>{{ optional(optional($item->viagem)->motorista)->nome ?? '-' }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="6">Sem abastecimentos no período.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>