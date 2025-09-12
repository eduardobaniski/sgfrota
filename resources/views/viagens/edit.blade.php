@extends('layout')

@section('title', 'Gerenciar Viagem')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gerenciar Viagem</h1>
            <p class="text-gray-600 mt-1">
                Caminhão: <span class="font-bold text-gray-900">{{ $viagem->caminhao->placa }}</span>
                <x-delete :action="route('viagens.destroy', $viagem->id)"> Apagar viagem</x-delete>
            </p>
        </div>

        <!-- Bloco 1: Detalhes da Viagem (Apenas para visualização) -->
        <div id="detalhes-viagem-readonly" class="mb-4 bg-gray-50 p-4 rounded-md border">
            <h2 class="font-semibold text-lg mb-2 text-gray-700">Detalhes da Viagem</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Origem</p>
                    <p class="font-medium">{{ $viagem->origem->name }} - {{ $viagem->origem->state->abbr }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Destino</p>
                    <p class="font-medium">{{ $viagem->destino->name }} - {{ $viagem->destino->state->abbr }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Início</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($viagem->dataInicio)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Odômetro Inicial</p>
                    <p class="font-medium">{{ number_format($viagem->odometroInicio, 0, ',', '.') }} km</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-500">Motorista</p>
                    <p class="font-medium">{{ optional($viagem->motorista)->nome ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Botão para Ativar a Edição -->
        
        <form action="{{ route('viagens.update', $viagem->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Bloco 2: Campos para Editar Dados Iniciais (Oculto por padrão) -->
            <div id="campos-edicao-viagem" class="hidden">
                <h2 class="font-semibold text-lg mb-4 text-gray-700">Editar Dados Iniciais</h2>

                <div class="mb-4">
                    <label for="motorista_id" class="block text-sm font-medium text-gray-700">Motorista</label>
                    <select id="motorista_id" name="motorista_id"
                        @class(['mt-1 block w-full p-2 border rounded-md shadow-sm', 'border-red-500' => $errors->has('motorista_id'), 'border-gray-300' => ! $errors->has('motorista_id')])>
                        <option value="">Selecione...</option>
                        @foreach($motoristas as $motorista)
                            <option value="{{ $motorista->id }}" {{ old('motorista_id', $viagem->motorista_id) == $motorista->id ? 'selected' : '' }}>
                                {{ $motorista->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('motorista_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Origem -->
                <fieldset class="mb-4 border p-4 rounded-md">
                    <legend class="text-sm font-medium text-gray-700 px-2">Origem</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="origem_uf" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select id="origem_uf" name="origem_uf" class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                                <option value="" disabled>Selecione...</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}" {{ old('origem_uf', $viagem->origem->state->id) == $estado->id ? 'selected' : '' }}>{{ $estado->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="origem_id" class="block text-sm font-medium text-gray-700">Cidade</label>
                            <select id="origem_id" name="cidadeOrigem" class="mt-1 block w-full p-2 border rounded-md shadow-sm" disabled></select>
                        </div>
                    </div>
                </fieldset>
                <!-- Destino -->
                <fieldset class="mb-4 border p-4 rounded-md">
                    <legend class="text-sm font-medium text-gray-700 px-2">Destino</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="destino_uf" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select id="destino_uf" name="destino_uf" class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                                <option value="" disabled>Selecione...</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}" {{ old('destino_uf', $viagem->destino->state->id) == $estado->id ? 'selected' : '' }}>{{ $estado->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="destino_id" class="block text-sm font-medium text-gray-700">Cidade</label>
                            <select id="destino_id" name="cidadeDestino" class="mt-1 block w-full p-2 border rounded-md shadow-sm" disabled></select>
                        </div>
                    </div>
                </fieldset>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Campo Data de Início (para edição) -->
                <div class="mb-4">
                    <label for="dataInicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
                    <input type="date" id="dataInicio" name="dataInicio" value="{{ old('dataInicio', \Carbon\Carbon::parse($viagem->dataInicio)->format('Y-m-d')) }}" class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                </div>

                <!-- Campo Odômetro Inicial (para edição) -->
                <div class="mb-4">
                    <label for="odometroInicio" class="block text-sm font-medium text-gray-700">Odômetro Inicial (km)</label>
                    <input type="number" id="odometroInicio" name="odometroInicio" value="{{ old('odometroInicio', $viagem->odometroInicio) }}" class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                </div>
            </div>
                <div class="border-b mb-6 pb-6"></div>
            </div>
            
            <!-- Bloco 3: Campos para Finalizar a Viagem -->
            <h2 class="font-semibold text-lg mb-4 text-gray-700">Finalizar Viagem</h2>
            <!-- Data de Fim -->
            <div class="mb-4">
                <label for="dataFim" class="block text-sm font-medium text-gray-700">Data de Finalização</label>
                <input type="date" id="dataFim" name="dataFim" value="{{ old('dataFim', now()->format('Y-m-d')) }}" required class="mt-1 block w-full p-2 border rounded-md shadow-sm">
            </div>
            <!-- Odômetro Final -->
            <div class="mb-6">
                <label for="odometroFinal" class="block text-sm font-medium text-gray-700">Odômetro Final (km)</label>
                <input type="number" id="odometroFinal" name="odometroFinal" value="{{ old('odometroFinal') }}"  class="mt-1 block w-full p-2 border rounded-md shadow-sm">
            </div>
            
            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-4">
                <div id="botao-editar-container" class="mb-6">
                    <button type="button" id="botao-editar-dados" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        Alterar Dados Iniciais da Viagem
                    </button>
                </div>
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
                <button type="submit" id="btn-salvar" name="action" value="save" class="hidden bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar alterações</button>
                <button type="submit" name="action" value="finalize" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Finalizar Viagem</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botaoEditar = document.getElementById('botao-editar-dados');
            const containerBotao = document.getElementById('botao-editar-container');
            const detalhesReadonly = document.getElementById('detalhes-viagem-readonly');
            const camposEdicao = document.getElementById('campos-edicao-viagem');
            const btnSalvar = document.getElementById('btn-salvar');

            botaoEditar.addEventListener('click', function() {
                containerBotao.classList.add('hidden');
                detalhesReadonly.classList.add('hidden');
                camposEdicao.classList.remove('hidden');
                btnSalvar.classList.remove('hidden');
            });

            function setupDependentDropdown(ufSelectId, cidadeSelectId, selectedStateId, selectedCityId) {
                const ufSelect = document.getElementById(ufSelectId);
                const cidadeSelect = document.getElementById(cidadeSelectId);

                function carregarCidades(estadoId, cidadePreSelecionada = null) {
                    cidadeSelect.innerHTML = '<option>A carregar...</option>';
                    cidadeSelect.disabled = true;
                    fetch(`/api/estados/${estadoId}/cidades`)
                        .then(response => response.json())
                        .then(cidades => {
                            cidadeSelect.innerHTML = '<option value="" disabled>Selecione...</option>';
                            cidades.forEach(cidade => {
                                const option = document.createElement('option');
                                option.value = cidade.id;
                                option.textContent = cidade.name;
                                if (cidade.id == cidadePreSelecionada) {
                                    option.selected = true;
                                }
                                cidadeSelect.appendChild(option);
                            });
                            cidadeSelect.disabled = false;
                        });
                }

                ufSelect.addEventListener('change', function() {
                    carregarCidades(this.value);
                });

                if (selectedStateId) {
                    carregarCidades(selectedStateId, selectedCityId);
                }
            }

            setupDependentDropdown('origem_uf', 'origem_id', "{{ old('origem_uf', $viagem->origem->state->id) }}", "{{ old('cidadeOrigem', $viagem->cidadeOrigem) }}");
            setupDependentDropdown('destino_uf', 'destino_id', "{{ old('destino_uf', $viagem->destino->state->id) }}", "{{ old('cidadeDestino', $viagem->cidadeDestino) }}");
        });
    </script>
@endsection
