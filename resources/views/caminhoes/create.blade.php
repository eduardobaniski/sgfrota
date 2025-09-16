@extends('layout')

@section('title', 'Novo Caminhão')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('caminhoes.store') }}" method="POST">
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
                    <input type="text" id="renavam" name="renavam" value="{{ old('renavam') }}" required maxlength="11" 
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
    document.addEventListener('DOMContentLoaded', function() {

        // --- INÍCIO: LÓGICA DE VALIDAÇÃO DO RENAVAM ---
        const renavamElement = document.getElementById('renavam');

        renavamElement.addEventListener('input', function (e) {
            // Remove qualquer caractere que não seja um número em tempo real
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
        // --- FIM: LÓGICA DE VALIDAÇÃO DO RENAVAM ---

        // --- INÍCIO: LÓGICA DE VALIDAÇÃO DA PLACA ---
        const placaElement = document.getElementById('placa');

        placaElement.addEventListener('input', function (e) {
            // 1. Remove qualquer caractere que não seja letra ou número
            let valor = e.target.value.replace(/[^a-zA-Z0-9]/g, '');

            // 2. Converte para maiúsculas
            valor = valor.toUpperCase();

            // 3. Limita o comprimento a 7 caracteres
            if (valor.length > 7) {
                valor = valor.slice(0, 7);
            }

            // 4. Atualiza o valor do campo
            e.target.value = valor;
        });
        // --- FIM: LÓGICA DE VALIDAÇÃO DA PLACA ---
        
        const marcaSelect = document.getElementById('marca');
        const modeloSelect = document.getElementById('modelo');

        // Preserva o modelo selecionado após erro de validação
        let oldModeloId = @json(old('modelo_id'));

        function carregarModelos(marcaId) {
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

                    modelos.forEach(m => {
                        const option = document.createElement('option');
                        option.value = m.id;
                        // Usa o campo correto da API e fallbacks
                        option.textContent = (m.nome ?? m.modelo ?? m.name ?? '').toString();
                        if (oldModeloId && Number(oldModeloId) === Number(m.id)) {
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

        marcaSelect.addEventListener('change', function() {
            // Ao trocar a marca, não reaproveitar o modelo anterior
            oldModeloId = null;
            const marcaId = this.value;
            carregarModelos(marcaId);
        });

        if (marcaSelect.value) {
            carregarModelos(marcaSelect.value);
        }
    });
</script>
@endsection
