@extends('layout')

@section('title', 'Editar Motorista')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Editar Motorista</h1>
                <p class="text-gray-600 mt-1">Atualize os dados do motorista selecionado.</p>
            </div>
            <x-delete :action="route('motorista.destroy', $motorista)" />
        </div>

        <form id="motorista-form" action="{{ route('motorista.update', $motorista) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Campo Nome -->
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome', $motorista->nome) }}" required
                       @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('nome'), 'border-gray-300' => ! $errors->has('nome')])>
                @error('nome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo CPF -->
            <div>
                <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $motorista->cpf) }}" required
                       placeholder="123.456.789-12"
                       @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('cpf'), 'border-gray-300' => ! $errors->has('cpf')])>
                @error('cpf')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo CNH -->
            <div>
                <label for="cnh" class="block text-sm font-medium text-gray-700">CNH</label>
                <input type="text" id="cnh" name="cnh" value="{{ old('cnh', $motorista->cnh) }}" required
                       placeholder="00000000000"
                       @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('cnh'), 'border-gray-300' => ! $errors->has('cnh')])>
                @error('cnh')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Telefone -->
            <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $motorista->telefone) }}"
                    placeholder="(00) 00000-0000"
                    @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('telefone'), 'border-gray-300' => ! $errors->has('telefone')])>
                @error('telefone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ações -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('motorista.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            const cnhInput = document.getElementById('cnh');
            const telefoneInput = document.getElementById('telefone');
            const form = document.getElementById('motorista-form');

            // Máscara CPF
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '').slice(0, 11);
                if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
                } else if (value.length > 3) {
                    value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
                }
                e.target.value = value;
            });

            // Máscara CNH (apenas números, 11 dígitos)
            cnhInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '').slice(0, 11);
            });

            // Máscara Telefone
            telefoneInput.addEventListener('input', function(e) {
                const numeros = e.target.value.replace(/\D/g, '').slice(0, 11);
                let formatado = '';
                if (numeros.length > 10) {
                    formatado = numeros.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                } else if (numeros.length > 6) {
                    formatado = numeros.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                } else if (numeros.length > 2) {
                    formatado = numeros.replace(/(\d{2})(\d{0,5})/, '($1) $2');
                } else if (numeros.length > 0) {
                    formatado = `(${numeros}`;
                }
                e.target.value = formatado;
            });

            // Remover máscaras no submit
            form.addEventListener('submit', function() {
                cpfInput.value = cpfInput.value.replace(/\D/g, '');
                cnhInput.value = cnhInput.value.replace(/\D/g, '');
                telefoneInput.value = telefoneInput.value.replace(/\D/g, '');
            });
        });
    </script>
@endsection