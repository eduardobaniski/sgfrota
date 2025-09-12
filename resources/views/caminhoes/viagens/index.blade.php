@extends('layout')
@section('title', 'Viagens do Caminhão')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-6xl mx-auto">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Viagens do Caminhão {{ $caminhao->placa }}</h1>
    </div>
    <a href="{{ route('caminhoes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Voltar</a>
  </div>

  <div class="mt-6 overflow-hidden rounded-lg border border-gray-200">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Início</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Fim</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Origem</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Destino</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Motorista</th>
            <th class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 sm:pr-6">Ações</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
          @forelse($viagens as $viagem)
            <tr class="hover:bg-gray-50">
              <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ \Carbon\Carbon::parse($viagem->dataInicio)->format('d/m/Y') }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $viagem->dataFim ? \Carbon\Carbon::parse($viagem->dataFim)->format('d/m/Y') : '-' }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $viagem->origem->name }} - {{ $viagem->origem->state->abbr }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ $viagem->destino->name }} - {{ $viagem->destino->state->abbr }}</td>
              <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">{{ optional($viagem->motorista)->nome ?? '-' }}</td>
              <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                <a href="{{ route('viagens.edit', $viagem->id) }}" class="text-indigo-600 hover:text-indigo-900">Consultar</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-3 py-10 text-center text-sm text-gray-500">Nenhuma viagem encontrada.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-4">{{ $viagens->withQueryString()->links() }}</div>
</div>
@endsection
