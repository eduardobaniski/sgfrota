@extends('layout')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Registar Nova Marca</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('cadastro.marca.store') }}" method="POST">
            @csrf

            <!-- Campo Nome da Marca -->
            <div class="mb-6">
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome da Marca</label>
                <input type="text" id="marca" name="marca" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('nome') border-red-500 @else border-gray-300 @enderror">
                
                {{-- Exibe a mensagem de erro de validação para o campo 'nome' --}}
                @error('nome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botão de Submissão -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Salvar Marca
                </button>
            </div>
        </form>
    </div>
@endsection
