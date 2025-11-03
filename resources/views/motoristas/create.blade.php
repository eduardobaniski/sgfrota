@extends('layout')

@section('title', 'Cadastrar Motorista')
@section('help')
    <p>Preencha os dados principais do motorista para criar um novo registro na frota.</p>
    <p>Valide CPF, CNH e datas antes de salvar; a máscara é removida automaticamente no envio do formulário.</p>
@endsection

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Cadastrar Motorista</h1>
            <p class="text-gray-600 mt-1">Preencha os dados abaixo para registrar um novo motorista.</p>
        </div>

        <form id="motorista-form" action="{{ route('motorista.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Campo Nome -->
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                       @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('nome'), 'border-gray-300' => ! $errors->has('nome')])>
                @error('nome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo CPF -->
            <div>
                <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" required
                       placeholder="123.456.789-12"
                       @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('cpf'), 'border-gray-300' => ! $errors->has('cpf')])>
                @error('cpf')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo CNH -->
            <div>
                <label for="cnh" class="block text-sm font-medium text-gray-700">CNH</label>
                <input type="text" id="cnh" name="cnh" value="{{ old('cnh') }}" required
                       placeholder="00000000000"
                       @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('cnh'), 'border-gray-300' => ! $errors->has('cnh')])>
                @error('cnh')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Validade da CNH -->
            <div>
                <label for="cnh_validade" class="block text-sm font-medium text-gray-700">Validade da CNH</label>
                <input type="date" id="cnh_validade" name="cnh_validade" value="{{ old('cnh_validade') }}" required
                       @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('cnh_validade'), 'border-gray-300' => ! $errors->has('cnh_validade')])>
                @error('cnh_validade')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Telefone -->
            <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}"
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
