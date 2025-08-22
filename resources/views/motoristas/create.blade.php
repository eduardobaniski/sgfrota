@extends('layout')

@section('title', 'Registar Novo Motorista')

@section('content')

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('motorista.store') }}" method="POST">
            @csrf

            <!-- Campo Nome -->
            <div class="mb-4">
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('nome') border-red-500 @else border-gray-300 @enderror">
                @error('nome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo CPF -->
            <div class="mb-4">
                <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" required
                       placeholder="123.456.789-12"
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('cpf') border-red-500 @else border-gray-300 @enderror">
                @error('cpf')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo CNH -->
            <div class="mb-6">
                <label for="cnh" class="block text-sm font-medium text-gray-700">CNH</label>
                <input type="text" id="cnh" name="cnh" value="{{ old('cnh') }}" required
                       placeholder="00000000000"
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('cnh') border-red-500 @else border-gray-300 @enderror">
                @error('cnh')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Telefone -->
            <div class="mb-6">
                <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" required
                    placeholder="(00) 00000-0000"
                    class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('telefone') border-red-500 @else border-gray-300 @enderror">
                @error('telefone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botão de Submissão -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Registar Motorista
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            const cnhInput = document.getElementById('cnh');
            
            // CORRIGIDO: Encontra o formulário a partir de um dos seus campos
            const form = cpfInput.closest('form');

            // Máscara para CPF (enquanto o utilizador digita)
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                value = value.slice(0, 11);
                
                if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
                } else if (value.length > 3) {
                    value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
                }
                
                e.target.value = value;
            });

            // Máscara para CNH (apenas números, enquanto o utilizador digita)
            cnhInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                value = value.slice(0, 11);
                e.target.value = value;
            });

            // Remove as máscaras antes de submeter o formulário
            if (form) {
                form.addEventListener('submit', function() {
                    cpfInput.value = cpfInput.value.replace(/\D/g, '');
                    cnhInput.value = cnhInput.value.replace(/\D/g, '');
                });
            }
        });

        // Captura o elemento do formulário e do telefone
        const form = document.getElementById('motorista-form');
        const telefoneInput = document.getElementById('telefone');

        // Função que formata o valor do telefone
        function formatarTelefone(valor) {
            // 1. Remove tudo o que não é dígito
            const numeros = valor.replace(/\D/g, '');
            
            // 2. Limita o comprimento a 11 dígitos
            const numerosLimitados = numeros.slice(0, 11);

            // 3. Aplica a máscara com base no comprimento
            if (numerosLimitados.length > 10) {
                // Celular: (XX) XXXXX-XXXX
                return numerosLimitados.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (numerosLimitados.length > 6) {
                // Fixo: (XX) XXXX-XXXX
                return numerosLimitados.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            } else if (numerosLimitados.length > 2) {
                // DDD + Início do número: (XX) XXXX
                return numerosLimitados.replace(/(\d{2})(\d{1,4})/, '($1) $2');
            } else if (numerosLimitados.length > 0) {
                // Apenas o DDD: (XX
                return `(${numerosLimitados}`;
            } else {
                // Vazio
                return '';
            }
        }

        // "Ouve" cada vez que o utilizador digita algo
        telefoneInput.addEventListener('input', (e) => {
            e.target.value = formatarTelefone(e.target.value);
});

    </script>
@endsection
