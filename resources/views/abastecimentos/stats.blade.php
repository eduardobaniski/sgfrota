@extends('layout')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-base font-semibold leading-6 text-gray-900">Estatísticas de Consumo</h1>
      <p class="mt-2 text-sm text-gray-700">Resumo e série mensal dos abastecimentos.</p>
    </div>
  </div>

  @if(!empty($filters))
    <div class="mt-4 space-x-2">
      @foreach($filters as $k => $v)
        @if($v !== null && $v !== '')
          <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">{{ str_replace('_',' ', $k) }}: {{ $v }}</span>
        @endif
      @endforeach
    </div>
  @endif

  <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
      <dt class="truncate text-sm font-medium text-gray-500">Abastecimentos</dt>
      <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($summary['abastecimentos'] ?? 0, 0, ',', '.') }}</dd>
    </div>
    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
      <dt class="truncate text-sm font-medium text-gray-500">Total de Litros</dt>
      <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($summary['total_litros'] ?? 0, 3, ',', '.') }} L</dd>
    </div>
    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
      <dt class="truncate text-sm font-medium text-gray-500">Total Gasto</dt>
      <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">R$ {{ number_format($summary['total_gasto'] ?? 0, 2, ',', '.') }}</dd>
    </div>
    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
      <dt class="truncate text-sm font-medium text-gray-500">Preço Médio por Litro</dt>
      <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $summary['media_preco_por_litro'] !== null ? 'R$ '.number_format($summary['media_preco_por_litro'], 3, ',', '.') : '-' }}</dd>
    </div>
  </div>

  <div class="mt-8">
    <div class="overflow-hidden rounded-lg bg-white shadow">
      <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Mês</th>
            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Abastecimentos</th>
            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Litros</th>
            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Total</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
          @forelse($por_mes as $linha)
            <tr>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $linha->ano_mes }}</td>
              <td class="px-4 py-3 text-right text-sm text-gray-700">{{ number_format($linha->qtd, 0, ',', '.') }}</td>
              <td class="px-4 py-3 text-right text-sm text-gray-700">{{ number_format((float)$linha->total_litros, 3, ',', '.') }} L</td>
              <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">R$ {{ number_format((float)$linha->total_gasto, 2, ',', '.') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">Sem dados para o período.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
