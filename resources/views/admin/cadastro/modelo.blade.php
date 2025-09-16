{{-- filepath: c:\Users\cadub\sgfrota\resources\views\admin\cadastro\modelo.blade.php --}}
@extends('layout')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Cadastrar Modelo</h1>
            <p class="text-gray-600 mt-1">Preencha os dados abaixo para registrar um novo modelo.</p>
        </div>

        <form action="/cadastro/modelo" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="marca_id" class="block text-sm font-medium text-gray-700">Marca</label>
                <select id="marca_id" name="marca_id" required
                        @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('marca_id'), 'border-gray-300' => ! $errors->has('marca_id')])>
                    <option value="" disabled {{ old('marca_id') ? '' : 'selected' }}>Selecione uma Marca</option>
                    @foreach($marcas as $id => $nome)
                        <option value="{{ $id }}" {{ (string)old('marca_id') === (string)$id ? 'selected' : '' }}>
                            {{ $nome }}
                        </option>
                    @endforeach
                </select>
                @error('marca_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="modelo" class="block text-sm font-medium text-gray-700">Nome do Modelo</label>
                <input type="text" id="modelo" name="modelo" value="{{ old('modelo') }}" required
                       @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('modelo'), 'border-gray-300' => ! $errors->has('modelo')])
                       >
                @error('modelo')
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