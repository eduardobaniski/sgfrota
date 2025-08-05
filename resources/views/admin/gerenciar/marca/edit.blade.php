@extends('layout')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Marca</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        {{-- O formulário aponta para a rota de update e usa o método PUT --}}
        <form action="{{ route('admin.gerenciar.marca.update', $marca->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Informa ao Laravel que esta é uma requisição de atualização --}}

            <!-- Campo Nome da Marca -->
            <div class="mb-6">
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome da Marca</label>
                {{-- O campo já vem preenchido com o nome atual da marca. A função old() garante que, se a validação falhar, o valor digitado pelo utilizador seja mantido. --}}
                <input type="text" id="nome" name="nome" value="{{ old('nome', $marca->marca) }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('nome') border-red-500 @else border-gray-300 @enderror">
                
                @error('nome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.gerenciar.marca.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
@endsection
