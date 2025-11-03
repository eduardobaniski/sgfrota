{{-- filepath: resources/views/admin/cadastro/cidade.blade.php --}}
@extends('layout')
@section('title', 'Cadastrar Cidade')
@section('help')
    <p>Inclua novas cidades selecionando previamente o estado correspondente.</p>
    <p>Após preencher o nome, salve para disponibilizar a cidade nas viagens e demais cadastros.</p>
@endsection
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Cadastrar Cidade</h1>
            <p class="text-gray-600 mt-1">Preencha os dados abaixo para registrar uma nova cidade.</p>
        </div>

        <form action="{{ route('cadastro.cidade.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="state_id" class="block text-sm font-medium text-gray-700">Estado</label>
                <select id="state_id" name="state_id" required
                        @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('state_id'), 'border-gray-300' => ! $errors->has('state_id')])>
                    <option value="" disabled {{ old('state_id') ? '' : 'selected' }}>Selecione um Estado</option>
                    @foreach($estados as $id => $nome)
                        <option value="{{ $id }}" {{ (string)old('state_id') === (string)$id ? 'selected' : '' }}>
                            {{ $nome }}
                        </option>
                    @endforeach
                </select>
                @error('state_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="cidade" class="block text-sm font-medium text-gray-700">Nome da Cidade</label>
                <input type="text" id="cidade" name="cidade" value="{{ old('cidade') }}" required
                       @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('cidade'), 'border-gray-300' => ! $errors->has('cidade')])
                       >
                @error('cidade')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Voltar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Cadastrar
                </button>
            </div>
        </form>
    </div>
@endsection