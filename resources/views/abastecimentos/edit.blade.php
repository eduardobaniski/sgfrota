@extends('layout')

@section('content')
<div class="mt-6 bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">Editar abastecimento {{ $abastecimento->id }}</h1>
        <p class="mt-2 text-sm text-gray-700">Atualize os dados do abastecimento.</p>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <a href="{{ route('abastecimentos.show', $abastecimento) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
      </div>
    </div>

    <form method="POST" action="{{ route('abastecimentos.update', $abastecimento) }}" class="space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
          <label for="caminhao_id" class="block text-sm font-medium text-gray-700">Caminhão (ID)</label>
          <input type="number" id="caminhao_id" name="caminhao_id" value="{{ old('caminhao_id', $abastecimento->caminhao_id) }}" required
                 @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('caminhao_id'), 'border-gray-300' => ! $errors->has('caminhao_id')])>
          @error('caminhao_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="viagem_id" class="block text-sm font-medium text-gray-700">Viagem (ID)</label>
          <input type="number" id="viagem_id" name="viagem_id" value="{{ old('viagem_id', $abastecimento->viagem_id) }}"
                 @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('viagem_id'), 'border-gray-300' => ! $errors->has('viagem_id')])>
          @error('viagem_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="data" class="block text-sm font-medium text-gray-700">Data</label>
          <input type="date" id="data" name="data" value="{{ old('data', optional($abastecimento->data)->format('Y-m-d')) }}" required
                 @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('data'), 'border-gray-300' => ! $errors->has('data')])>
          @error('data')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="odometro" class="block text-sm font-medium text-gray-700">Odômetro</label>
          <input type="number" id="odometro" name="odometro" value="{{ old('odometro', $abastecimento->odometro) }}" min="0"
                 @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('odometro'), 'border-gray-300' => ! $errors->has('odometro')])>
          @error('odometro')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="litros" class="block text-sm font-medium text-gray-700">Litros</label>
          <input type="number" id="litros" name="litros" step="0.001" value="{{ old('litros', $abastecimento->litros) }}" required
                 @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('litros'), 'border-gray-300' => ! $errors->has('litros')])>
          @error('litros')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="preco_por_litro" class="block text-sm font-medium text-gray-700">Preço por litro</label>
          <input type="number" id="preco_por_litro" name="preco_por_litro" step="0.001" value="{{ old('preco_por_litro', $abastecimento->preco_por_litro) }}"
                 @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('preco_por_litro'), 'border-gray-300' => ! $errors->has('preco_por_litro')])>
          @error('preco_por_litro')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="valor_total" class="block text-sm font-medium text-gray-700">Valor total</label>
          <input type="number" id="valor_total" name="valor_total" step="0.01" value="{{ old('valor_total', $abastecimento->valor_total) }}"
                 @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('valor_total'), 'border-gray-300' => ! $errors->has('valor_total')])>
          @error('valor_total')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div>
        <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
        <textarea id="observacoes" name="observacoes" rows="4"
                  @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('observacoes'), 'border-gray-300' => ! $errors->has('observacoes')])>{{ old('observacoes', $abastecimento->observacoes) }}</textarea>
        @error('observacoes')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">Salvar</button>
      </div>
    </form>
  </div>
</div>
@endsection
