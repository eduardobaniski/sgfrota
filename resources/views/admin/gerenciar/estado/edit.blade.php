@extends('layout')
@section('title', 'Editar Estado')
@section('help')
    <p>Corrija o nome ou a sigla de um estado já cadastrado conforme necessário.</p>
    <p>Mantenha a sigla com duas letras e use Cancelar para sair sem salvar.</p>
@endsection
@section('content')

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('admin.gerenciar.estado.update', $estado->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome do Estado</label>
                <input type="text" id="nome" name="name" value="{{ old('name', $estado->name) }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('name') border-red-500 @else border-gray-300 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="abbr" class="block text-sm font-medium text-gray-700">Sigla (2 letras)</label>
                <input type="text" id="abbr" name="abbr" value="{{ old('abbr', $estado->abbr) }}" maxlength="2" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm uppercase @error('abbr') border-red-500 @else border-gray-300 @enderror">
                @error('abbr')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.gerenciar.estado.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
@endsection