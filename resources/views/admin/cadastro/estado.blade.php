@extends('layout')

@section('title', 'Novo Estado')
@section('help')
    <p>Cadastre um novo estado para habilitar o uso nas cidades e viagens.</p>
    <p>Informe o nome completo e a sigla com duas letras antes de salvar.</p>
@endsection

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Registar Novo Estado</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('cadastro.estado.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome do Estado</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('name') border-red-500 @else border-gray-300 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="abbr" class="block text-sm font-medium text-gray-700">Sigla (2 letras)</label>
                <input type="text" id="abbr" name="abbr" value="{{ old('abbr') }}" maxlength="2" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm uppercase @error('abbr') border-red-500 @else border-gray-300 @enderror">
                @error('abbr')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Voltar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Salvar Estado
                </button>
            </div>
        </form>
    </div>
@endsection
