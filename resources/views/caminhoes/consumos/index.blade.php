@extends('layout')
@section('title', 'Consumo do Caminhão')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-6xl mx-auto">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Consumo do Caminhão {{ $caminhao->placa }}</h1>
      <p class="mt-1 text-sm text-gray-600">Filtre por período e viagem para analisar o consumo.</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('caminhoes.consumos.export', [$caminhao, 'csv']) }}?{{ http_build_query($filters) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Exportar CSV</a>
      <a href="{{ route('caminhoes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Voltar</a>
    </div>
  </div>

  <form method="GET" class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div>
      <label for="data_inicio" class="block text-sm font-medium text-gray-700">Início</label>
      <input type="date" id="data_inicio" name="data_inicio" value="{{ $filters['data_inicio'] ?? '' }}" class="mt-1 block w-full p-2 border rounded-md shadow-sm border-gray-300">
    </div>
    <div>
      <label for="data_fim" class="block text-sm font-medium text-gray-700">Fim</label>
      <input type="date" id="data_fim" name="data_fim" value="{{ $filters['data_fim'] ?? '' }}" class="mt-1 block w-full p-2 border rounded-md shadow-sm border-gray-300">
    </div>
    <div>
      <label for="viagem_id" class="block text-sm font-medium text-gray-700">Viagem</label>
      <input type="number" id="viagem_id" name="viagem_id" value="{{ $filters['viagem_id'] ?? '' }}" class="mt-1 block w-full p-2 border rounded-md shadow-sm border-gray-300" placeholder="#ID da viagem">
    </div>
    <div class="flex items-end">
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filtrar</button>
    </div>
  </form>

  <!-- KPIs -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
    <div class="bg-gray-50 p-4 rounded border">
      <p class="text-xs text-gray-500">Total de litros</p>
      <p class="text-2xl font-semibold text-gray-800">{{ number_format($kpi['total_litros'], 3, ',', '.') }} L</p>
    </div>
    <div class="bg-gray-50 p-4 rounded border">
      <p class="text-xs text-gray-500">Gasto total</p>
      <p class="text-2xl font-semibold text-gray-800">R$ {{ number_format($kpi['total_gasto'], 2, ',', '.') }}</p>
    </div>
    <div class="bg-gray-50 p-4 rounded border">
      <p class="text-xs text-gray-500">Preço médio por litro</p>
      <p class="text-2xl font-semibold text-gray-800">{{ $kpi['media_preco_por_litro'] !== null ? 'R$ '.number_format($kpi['media_preco_por_litro'], 3, ',', '.') : '-' }}</p>
    </div>
    <div class="bg-gray-50 p-4 rounded border">
      <p class="text-xs text-gray-500">Consumo médio</p>
      <p class="text-2xl font-semibold text-gray-800">{{ $kpi['consumo_km_l'] !== null ? number_format($kpi['consumo_km_l'], 2, ',', '.') . ' km/L' : '-' }}</p>
      <p class="text-xs text-gray-500 mt-1">Baseado na variação de odômetro</p>
    </div>
  </div>

  <!-- Tabela de Abastecimentos -->
  <div class="mt-6 overflow-hidden rounded-lg border border-gray-200">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Data</th>
            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Litros</th>
            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Preço/L</th>
            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Total</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Viagem</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Motorista</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
          @forelse($items as $item)
            <tr class="hover:bg-gray-50">
              <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ optional($item->data)->format('d/m/Y') ?? $item->data }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-600">{{ number_format((float)$item->litros, 3, ',', '.') }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-600">{{ $item->preco_por_litro !== null ? 'R$ '.number_format((float)$item->preco_por_litro, 3, ',', '.') : '-' }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-medium text-gray-900">{{ $item->valor_total !== null ? 'R$ '.number_format((float)$item->valor_total, 2, ',', '.') : '-' }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">#{{ $item->viagem_id }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ optional(optional($item->viagem)->motorista)->nome ?? '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-3 py-10 text-center text-sm text-gray-500">Nenhum abastecimento encontrado.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-4">{{ $items->withQueryString()->links() }}</div>

  <!-- Placeholder para gráficos futuros usando /stats -->
  <div class="mt-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Evolução mensal (em breve)</h2>
    <p class="text-sm text-gray-500">Endpoint de dados: <code>/caminhoes/{{ $caminhao->id }}/consumos/stats?{{ http_build_query($filters) }}</code></p>
  </div>
</div>
@endsection