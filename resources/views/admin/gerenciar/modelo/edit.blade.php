@extends('layout')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Modelo</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        {{-- O formulário aponta para a rota de update e usa o método PUT --}}
        <form action="{{ route('admin.gerenciar.modelo.update', $modelo->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Informa ao Laravel que esta é uma requisição de atualização --}}

            <!-- Campo Nome do Modelo -->
            <div class="mb-4">
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome do Modelo</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome', $modelo->modelo) }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('nome') border-red-500 @else border-gray-300 @enderror">
                
                @error('nome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Marca -->
            <div class="mb-6">
                <label for="marca_id" class="block text-sm font-medium text-gray-700">Marca</label>
                <select id="marca_id" name="marca_id" required
                        class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('marca_id') border-red-500 @else border-gray-300 @enderror">
                    <option value="" disabled>Selecione uma marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id }}" 
                            {{-- Seleciona a marca atual do modelo --}}
                            @if($marca->id == old('marca_id', $modelo->marca_id)) selected @endif>
                            {{ $marca->marca }}
                        </option>
                    @endforeach
                </select>
                @error('marca_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.gerenciar.modelo.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
@endsection
