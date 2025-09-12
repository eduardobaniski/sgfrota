@extends('layout')
@section('title', 'Consumo Geral dos Caminhões')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-6xl mx-auto">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Consumo Geral dos Caminhões</h1>
      <p class="mt-1 text-sm text-gray-600">Visão consolidada por caminhão, com filtros por período.</p>
    </div>
    <a href="{{ route('caminhoes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Voltar</a>
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
    <div class="flex items-end">
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filtrar</button>
    </div>
  </form>

  <div class="mt-6 overflow-hidden rounded-lg border border-gray-200">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Placa</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Modelo</th>
            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Total Litros</th>
            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Gasto Total</th>
            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Abastecimentos</th>
            <th class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 sm:pr-6"><span class="sr-only">Detalhar</span></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
          @forelse($caminhoes as $c)
            <tr class="hover:bg-gray-50">
              <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $c->placa }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $c->modelo_nome }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-600">{{ number_format((float)$c->total_litros, 3, ',', '.') }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-600">R$ {{ number_format((float)$c->total_gasto, 2, ',', '.') }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-600">{{ (int)$c->abastecimentos }}</td>
              <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                <a href="{{ route('caminhoes.consumos.index', $c->id) }}?{{ http_build_query($filters) }}" class="text-indigo-600 hover:text-indigo-900">Consultar</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-3 py-10 text-center text-sm text-gray-500">Nenhum dado encontrado.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if(method_exists($caminhoes, 'links'))
    <div class="mt-4">{{ $caminhoes->withQueryString()->links() }}</div>
  @endif
</div>
@endsection