@extends('layout')

@section('title', 'Editar Caminhão')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Caminhão: {{ $caminhao->placa }}
            <x-delete :action="route('caminhoes.destroy', $caminhao->id)" />

        </h1>
            
        <form action="{{ route('caminhoes.update', $caminhao->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Informa ao Laravel que esta é uma requisição de atualização --}}
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Dropdown de Marcas -->
                <div>
                    <label for="marca" class="block text-sm font-medium text-gray-700">Marca</label>
                    <select id="marca" name="marca" required
                            class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('marca_id') border-red-500 @else border-gray-300 @enderror">
                        <option value="" disabled>Selecione uma marca...</option>
                        @foreach ($marcas as $marca)
                            {{-- Seleciona a marca atual do caminhão --}}
                            <option value="{{ $marca->id }}" {{ old('marca_id', $caminhao->modelo->marca_id) == $marca->id ? 'selected' : '' }}>
                                {{ $marca->marca }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown de Modelos (populado via JS) -->
                <div>
                    <label for="modelo" class="block text-sm font-medium text-gray-700">Modelo</label>
                    <select id="modelo" name="modelo_id" required
                            class="mt-1 block w-full p-2 border rounded-md shadow-sm @error('modelo_id') border-red-500 @else border-gray-300 @enderror" disabled>
                        <option>A carregar...</option>
                    </select>
                </div>

                <!-- Outros campos -->
                <div>
                    <label for="placa" class="block text-sm font-medium text-gray-700">Placa</label>
                    <input type="text" id="placa" name="placa" value="{{ old('placa', $caminhao->placa) }}" required
                           class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                </div>
                <div>
                    <label for="renavam" class="block text-sm font-medium text-gray-700">Renavam</label>
                    <input type="text" id="renavam" name="renavam" value="{{ old('renavam', $caminhao->renavam) }}" required
                           class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                </div>
                <div class="md:col-span-2">
                    <label for="ano_fabricacao" class="block text-sm font-medium text-gray-700">Ano de Fabricação</label>
                    <input type="number" id="ano_fabricacao" name="ano_fabricacao" value="{{ old('ano_fabricacao', $caminhao->ano_fabricacao) }}" required
                           class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ url()->previous() }}" onclick="event.preventDefault(); history.back();" class="text-gray-600 hover:text-gray-800 font-medium transition duration-300">
                    &larr; Voltar para a lista
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    {{-- Script para os Dropdowns Dependentes --}}
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const marcaSelect = document.getElementById('marca');
            const modeloSelect = document.getElementById('modelo');

            // A FUNÇÃO DEVE SER DEFINIDA ANTES DE SER CHAMADA
            function carregarModelos(marcaId, modeloParaSelecionarId = null) {
                if (!marcaId) {
                    modeloSelect.innerHTML = '<option selected disabled>Selecione a marca primeiro</option>';
                    modeloSelect.disabled = true;
                    return;
                }
                modeloSelect.innerHTML = '<option>A carregar...</option>';
                modeloSelect.disabled = true;
                fetch(`/api/marcas/${marcaId}/modelos`)
                    .then(response => response.json())
                    .then(modelos => {
                        modeloSelect.innerHTML = '<option value="" selected disabled>Selecione um modelo</option>';
                        modelos.forEach(modelo => {
                            const option = document.createElement('option');
                            option.value = modelo.id;
                            // CORRIGIDO: A propriedade correta é 'nome'
                            option.textContent = modelo.modelo; 
                            if (modelo.id == modeloParaSelecionarId) {
                                option.selected = true;
                            }
                            modeloSelect.appendChild(option);
                        });
                        modeloSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Erro ao buscar modelos:', error);
                        modeloSelect.innerHTML = '<option selected disabled>Erro ao carregar modelos</option>';
                    });
            }

            // AGORA QUE A FUNÇÃO ESTÁ DEFINIDA, PODEMOS USÁ-LA

            // Pega os IDs iniciais diretamente do PHP.
            const marcaInicialId = "{{ old('marca_id', $caminhao->modelo->marca_id) }}";
            const modeloInicialId = "{{ old('modelo_id', $caminhao->modelo_id) }}";
            
            console.log('IDs Iniciais:', { marca: marcaInicialId, modelo: modeloInicialId });

            // Se houver uma marca inicial, carrega os modelos correspondentes.
            if (marcaInicialId) {
                console.log('A carregar modelos iniciais...');
                carregarModelos(marcaInicialId, modeloInicialId);
            }

            // Adiciona o evento para carregar os modelos quando a marca muda.
            marcaSelect.addEventListener('change', function() {
                carregarModelos(this.value);
            });
        });
    </script>
@endsection
