@extends('layout')
@section('title', 'Editar Cidade')
@section('help')
    <p>Modifique o nome da cidade ou associe-a a outro estado quando necessário.</p>
    <p>Finalize com Salvar Alterações ou clique em Cancelar para voltar à listagem.</p>
@endsection
@section('content')

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('admin.gerenciar.cidade.update', $cidade->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome da Cidade</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome', $cidade->name) }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('nome') border-red-500 @else border-gray-300 @enderror">
                @error('nome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="state_id" class="block text-sm font-medium text-gray-700">Estado</label>
                <select id="state_id" name="state_id" required
                        class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('state_id') border-red-500 @else border-gray-300 @enderror">
                    <option value="" disabled>Selecione um estado</option>
                    @foreach ($estados->sortBy('name') as $estado)
                        <option value="{{ $estado->id }}" @if($estado->id == old('state_id', $cidade->state_id)) selected @endif>
                            {{ $estado->name }}
                        </option>
                    @endforeach
                </select>
                @error('state_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.gerenciar.cidade.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
@endsection