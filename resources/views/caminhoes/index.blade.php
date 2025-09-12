@extends('layout')
@section('title', 'Caminhões')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-6xl mx-auto">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Caminhões</h1>
      <p class="mt-1 text-sm text-gray-600">Lista de caminhões registrados na frota.</p>
    </div>
    <a href="{{ route('caminhoes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Novo caminhão</a>
  </div>

  <div class="mt-6 overflow-hidden rounded-lg border border-gray-200">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Placa</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Modelo</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Ano</th>
            <th class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 sm:pr-6">Ações</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
          @forelse($caminhoes as $caminhao)
            <tr class="hover:bg-gray-50">
              <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $caminhao->placa }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">
                {{ optional(optional($caminhao->modelo)->marca)->marca }} {{ optional($caminhao->modelo)->modelo }}
              </td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $caminhao->ano_fabricacao }}</td>
              <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                <a href="{{ route('caminhoes.edit', $caminhao) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                <a href="{{ route('caminhoes.viagens.index', $caminhao) }}" class="ml-4 text-purple-600 hover:text-purple-800">Ver viagens</a>
                <a href="{{ route('caminhoes.consumos.index', $caminhao) }}" class="ml-4 text-teal-600 hover:text-teal-800">Consultar dados</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-3 py-10 text-center text-sm text-gray-500">Nenhum caminhão encontrado.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if(method_exists($caminhoes, 'links'))
    <div class="mt-4">{{ $caminhoes->links() }}</div>
  @endif
</div>
@endsection