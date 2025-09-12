@extends('layout')

@section('title', 'Iniciar Nova Viagem')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Iniciar Nova Viagem</h1>
            <p class="text-gray-600 mt-1">
                Para o caminhão: <span class="font-bold text-gray-900">{{ $caminhao->placa }}</span>
            </p>
        </div>

        <form action="{{ route('viagens.store') }}" method="POST">
            @csrf
            <input type="hidden" name="caminhao_id" value="{{ $caminhao->id }}">

            <div class="mb-4">
                <label for="motorista_id" class="block text-sm font-medium text-gray-700">Motorista</label>
                <select id="motorista_id" name="motorista_id"
                        @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('motorista_id'), 'border-gray-300' => ! $errors->has('motorista_id')])>
                    <option value="">Selecione...</option>
                    @foreach($motoristas as $motorista)
                        <option value="{{ $motorista->id }}" {{ old('motorista_id') == $motorista->id ? 'selected' : '' }}>
                            {{ $motorista->nome }}
                        </option>
                    @endforeach
                </select>
                @error('motorista_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Origem -->
            <fieldset class="mb-4 border p-4 rounded-md">
                <legend class="text-sm font-medium text-gray-700 px-2">Origem</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="origem_uf" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="origem_uf" required class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                            <option value="" disabled selected>Selecione um estado...</option>
                            {{-- CORRIGIDO: Itera sobre a coleção de objetos State --}}
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="origem_cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                        <select id="origem_cidade" name="origem_id" required class="mt-1 block w-full p-2 border rounded-md shadow-sm" disabled>
                            <option value="" disabled selected>Selecione o estado primeiro</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- Campo Destino -->
            <fieldset class="mb-4 border p-4 rounded-md">
                <legend class="text-sm font-medium text-gray-700 px-2">Destino</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="destino_uf" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="destino_uf" required class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                            <option value="" disabled selected>Selecione um estado...</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="destino_cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                        <select id="destino_cidade" name="destino_id" required class="mt-1 block w-full p-2 border rounded-md shadow-sm" disabled>
                            <option value="" disabled selected>Selecione o estado primeiro</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="mb-4">
                <label for="odometroInicio" class="block text-sm font-medium text-gray-700">Odômetro Inicial (km)</label>
                <input type="number" id="odometroInicio" name="odometroInicio" value="{{ old('odometroInicio') }}"
                    @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('odometroInicio'), 'border-gray-300' => ! $errors->has('odometroInicio')])>
                @error('odometroInicio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Data de Início -->
            <div class="mb-6">
                <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <input type="date" id="data_inicio" name="data_inicio" value="{{ old('data_inicio', now()->format('Y-m-d')) }}" required
                       class="mt-1 block w-full p-2 border rounded-md shadow-sm">
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Iniciar Viagem</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Captura todos os elementos no início
            const origemUfSelect = document.getElementById('origem_uf');
            const origemCidadeSelect = document.getElementById('origem_cidade');
            const destinoUfSelect = document.getElementById('destino_uf');
            const destinoCidadeSelect = document.getElementById('destino_cidade');

            // Função reutilizável para buscar e preencher as cidades
            function carregarCidades(estadoId, cidadeSelectElement) {
                cidadeSelectElement.innerHTML = '<option>A carregar...</option>';
                cidadeSelectElement.disabled = true;

                if (!estadoId) {
                    cidadeSelectElement.innerHTML = '<option value="" disabled selected>Selecione o estado primeiro</option>';
                    return;
                }
                
                const apiUrl = `/api/estados/${estadoId}/cidades`;

                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Erro na rede: ${response.status} ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(cidades => {
                        cidadeSelectElement.innerHTML = '<option value="" disabled selected>Selecione uma cidade</option>';
                        cidades.forEach(cidade => {
                            const option = document.createElement('option');
                            
                            option.value = cidade.id;
                            option.textContent = cidade.name;
                            cidadeSelectElement.appendChild(option);
                        });
                        cidadeSelectElement.disabled = false;
                    })
                    .catch(error => {
                        cidadeSelectElement.innerHTML = '<option value="" disabled selected>Erro ao carregar.</option>';
                    });
            }

            // Configura o "ouvinte" de eventos para a Origem
            origemUfSelect.addEventListener('change', function() {
                carregarCidades(this.value, origemCidadeSelect);
            });

            // Configura o "ouvinte" de eventos para o Destino
            destinoUfSelect.addEventListener('change', function() {
                carregarCidades(this.value, destinoCidadeSelect);
            });
        });
    </script>
@endsection
