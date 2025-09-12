@extends('layout')
@section('title', 'Abastecimentos')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-6xl mx-auto">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Abastecimentos</h1>
      <p class="mt-1 text-sm text-gray-600">Últimos abastecimentos realizados (ordenados por data mais recente).</p>
      
      <div class="mt-2 flex flex-wrap gap-2">
        @if(isset($caminhao))
          <span class="inline-flex items-center px-3 py-1 rounded bg-gray-100 text-sm text-gray-700">
            Caminhão: {{ optional($caminhao)->placa ?? ('#'.optional($caminhao)->id) }}
          </span>
        @endif

        @if(isset($viagem))
          <span class="inline-flex items-center px-3 py-1 rounded bg-gray-100 text-sm text-gray-700">
            Viagem: {{ optional($viagem)->id }}@if(optional($viagem)->descricao) — {{ optional($viagem)->descricao }}@endif
          </span>
        @endif
      </div>
    </div>
    <div class="shrink-0">
      <a href="{{ route('abastecimentos.create', [
        'caminhao_id' => $filters['caminhao_id'] ?? optional($caminhao)->id,
        'viagem_id' => $filters['viagem_id'] ?? optional($viagem)->id,
      ]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">Adicionar abastecimento</a>
    </div>
  </div>



  <div class="mt-6 overflow-hidden rounded-lg border border-gray-200">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Data</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Caminhão</th>
            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Odômetro</th>
            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Litros</th>
            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Preço/L</th>
            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Total</th>
            <th scope="col" class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 sm:pr-6"><span class="sr-only">Ver</span></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
          @forelse($items as $item)
            <tr class="hover:bg-gray-50">
              <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ optional($item->data)->format('d/m/Y') ?? $item->data }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ optional($item->caminhao)->placa ?? ('#'.$item->caminhao_id) }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-600">{{ $item->odometro !== null ? number_format($item->odometro, 0, ',', '.') : '-' }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-600">{{ number_format((float)$item->litros, 3, ',', '.') }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-600">{{ $item->preco_por_litro !== null ? 'R$ '.number_format((float)$item->preco_por_litro, 3, ',', '.') : '-' }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-medium text-gray-900">{{ $item->valor_total !== null ? 'R$ '.number_format((float)$item->valor_total, 2, ',', '.') : '-' }}</td>
              <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                <a href="{{ route('abastecimentos.show', $item) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-3 py-10 text-center text-sm text-gray-500">Nenhum abastecimento encontrado.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-4">{{ $items->withQueryString()->links() }}</div>
</div>
@endsection
