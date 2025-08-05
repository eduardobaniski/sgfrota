@extends('layout')

@section('title', 'Novo Caminhão')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{--  --}}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Dropdown de Marcas -->
                <div>
                    <label for="marca" class="block text-sm font-medium text-gray-700">Marca</label>
                    <select id="marca" name="marca" required
                            class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('marca_id') border-red-500 @else border-gray-300 @enderror">
                        <option value="" selected disabled>Selecione uma marca...</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                {{ $marca->marca }}
                            </option>
                        @endforeach
                    </select>
                    @error('marca_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dropdown de Modelos (populado via JS) -->
                <div>
                    <label for="modelo" class="block text-sm font-medium text-gray-700">Modelo</label>
                    <select id="modelo" name="modelo_id" required
                            class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('modelo_id') border-red-500 @else border-gray-300 @enderror" disabled>
                        <option value="" selected disabled>Selecione a marca primeiro</option>
                    </select>
                     @error('modelo_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo Placa -->
                <div>
                    <label for="placa" class="block text-sm font-medium text-gray-700">Placa</label>
                    <input type="text" id="placa" name="placa" value="{{ old('placa') }}" required
                           class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('placa') border-red-500 @else border-gray-300 @enderror">
                    @error('placa')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo Renavam -->
                <div>
                    <label for="renavam" class="block text-sm font-medium text-gray-700">Renavam</label>
                    <input type="text" id="renavam" name="renavam" value="{{ old('renavam') }}" required
                           class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('renavam') border-red-500 @else border-gray-300 @enderror">
                    @error('renavam')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo Ano de Fabricação -->
                <div class="md:col-span-2">
                    <label for="ano_fabricacao" class="block text-sm font-medium text-gray-700">Ano de Fabricação</label>
                    <input type="number" id="ano_fabricacao" name="ano_fabricacao" value="{{ old('ano_fabricacao') }}" required
                           placeholder="Ex: 2023"
                           class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('ano_fabricacao') border-red-500 @else border-gray-300 @enderror">
                    @error('ano_fabricacao')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botão de Submissão -->
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Registar Caminhão
                </button>
            </div>
        </form>
    </div>

    {{-- Script para os Dropdowns Dependentes --}}
    <script>
    // Espera que todo o HTML da página seja carregado antes de executar o script
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Captura os elementos do formulário
        const marcaSelect = document.getElementById('marca');
        const modeloSelect = document.getElementById('modelo');

        // 2. Função para carregar os modelos
        function carregarModelos(marcaId) {
            // Se não houver um ID de marca, reseta o campo de modelo
            if (!marcaId) {
                modeloSelect.innerHTML = '<option selected disabled>Selecione a marca primeiro</option>';
                modeloSelect.disabled = true;
                return;
            }

            // Mostra uma mensagem de "a carregar" enquanto busca os dados
            modeloSelect.innerHTML = '<option>A carregar...</option>';
            modeloSelect.disabled = true;

            // 3. Faz a chamada à sua API
            // Lembre-se de verificar se o URL está correto (/api/marcas/... ou /marcas/...)
            fetch(`/api/marcas/${marcaId}/modelos`)
                .then(response => response.json())
                .then(modelos => {
                    // Limpa o dropdown de modelos
                    modeloSelect.innerHTML = '<option value="" selected disabled>Selecione um modelo</option>';

                    // 4. Preenche o dropdown com os modelos recebidos
                    modelos.forEach(modelo => {
                        const option = document.createElement('option');
                        option.value = modelo.id;
                        option.textContent = modelo.modelo;
                        modeloSelect.appendChild(option);
                    });

                    // Ativa o dropdown de modelos
                    modeloSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Erro ao buscar modelos:', error);
                    modeloSelect.innerHTML = '<option selected disabled>Erro ao carregar modelos</option>';
                });
        }

        // 5. Adiciona o "ouvinte" que ativa a busca
        // Quando o valor de 'marca' muda, a função carregarModelos é chamada
        marcaSelect.addEventListener('change', function() {
            // 'this.value' pega o valor do atributo "value" da <option> selecionada
            const marcaId = this.value; 
            carregarModelos(marcaId);
        });

        // 6. Lógica para o caso de a página recarregar com um valor antigo (após falha de validação)
        if (marcaSelect.value) {
            carregarModelos(marcaSelect.value);
        }
    });
</script>
@endsection
