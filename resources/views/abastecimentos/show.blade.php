@extends('layout')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center sm:justify-between">
    <div class="sm:flex-auto">
      <h1 class="text-base font-semibold leading-6 text-gray-900">Abastecimento #{{ $abastecimento->id }}</h1>
      <p class="mt-2 text-sm text-gray-700">Detalhes do abastecimento.</p>
    </div>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex gap-2">
      <a href="{{ route('abastecimentos.edit', $abastecimento) }}" class="inline-flex items-center justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600">Editar</a>
      <x-delete :action="route('abastecimentos.destroy', $abastecimento)">Apagar abastecimento</x-delete>
    </div>
  </div>

  <div class="mt-6 overflow-hidden rounded-lg bg-white shadow">
    <table class="min-w-full divide-y divide-gray-300">
      <tbody class="divide-y divide-gray-200">
        <tr>
          <th class="w-1/3 bg-gray-50 px-4 py-3 text-left text-sm font-semibold text-gray-900">Data</th>
          <td class="px-4 py-3 text-sm text-gray-700">{{ optional($abastecimento->data)->format('d/m/Y H:i') ?? $abastecimento->data }}</td>
        </tr>
        <tr>
          <th class="bg-gray-50 px-4 py-3 text-left text-sm font-semibold text-gray-900">Viagem</th>
          <td class="px-4 py-3 text-sm text-gray-700">#{{ $abastecimento->viagem_id }}</td>
        </tr>
        <tr>
          <th class="bg-gray-50 px-4 py-3 text-left text-sm font-semibold text-gray-900">Caminhão</th>
          <td class="px-4 py-3 text-sm text-gray-700">{{ optional($abastecimento->caminhao)->placa ?? ('#'.$abastecimento->caminhao_id) }}</td>
        </tr>
        <tr>
          <th class="bg-gray-50 px-4 py-3 text-left text-sm font-semibold text-gray-900">Motorista</th>
          <td class="px-4 py-3 text-sm text-gray-700">{{ optional(optional($abastecimento->viagem)->motorista)->nome ?? '-' }}</td>
        </tr>
        <tr>
          <th class="bg-gray-50 px-4 py-3 text-left text-sm font-semibold text-gray-900">Odômetro</th>
          <td class="px-4 py-3 text-sm text-gray-700">{{ $abastecimento->odometro !== null ? number_format($abastecimento->odometro, 0, ',', '.') : '-' }}</td>
        </tr>
        <tr>
          <th class="bg-gray-50 px-4 py-3 text-left text-sm font-semibold text-gray-900">Litros</th>
          <td class="px-4 py-3 text-sm text-gray-700">{{ number_format((float)$abastecimento->litros, 3, ',', '.') }} L</td>
        </tr>
        <tr>
          <th class="bg-gray-50 px-4 py-3 text-left text-sm font-semibold text-gray-900">Preço por litro</th>
          <td class="px-4 py-3 text-sm text-gray-700">{{ $abastecimento->preco_por_litro !== null ? 'R$ '.number_format((float)$abastecimento->preco_por_litro, 3, ',', '.') : '-' }}</td>
        </tr>
        <tr>
          <th class="bg-gray-50 px-4 py-3 text-left text-sm font-semibold text-gray-900">Valor total</th>
          <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $abastecimento->valor_total !== null ? 'R$ '.number_format((float)$abastecimento->valor_total, 2, ',', '.') : '-' }}</td>
        </tr>
        <tr>
          <th class="bg-gray-50 px-4 py-3 text-left text-sm font-semibold text-gray-900">Observações</th>
          <td class="px-4 py-3 text-sm text-gray-700 whitespace-pre-line">{{ $abastecimento->observacoes ?? '-' }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
