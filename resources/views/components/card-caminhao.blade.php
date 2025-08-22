@props(['caminhao'])
<!-- Card do Caminhão -->
<div class="bg-white rounded-lg shadow-md p-5 border-l-4 
    @switch($caminhao->status)
        @case('Em Trânsito') border-blue-500 @break
        @case('Disponível') border-green-500 @break
        @case('Em Manutenção') border-yellow-500 @break
        @default border-gray-400 @endswitch
">
    <!-- Secção Principal de Informação -->
    <div class="flex justify-between items-start mb-4">
        <div>
            <!-- Container para o ícone e a placa -->
            <div class="flex items-center mb-1">
                <!-- SVG da Placa -->
                <svg class="w-6 h-6 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                
                <!-- Placa do Caminhão -->
                <p class="text-xl font-bold text-gray-800 tracking-wider">{{ $caminhao->placa }}</p>
            </div>

            <!-- Modelo e Marca -->
            <p class="text-sm text-gray-500 ml-8">
                {{ $caminhao->modelo->marca->marca }} {{ $caminhao->modelo->modelo }} - {{ $caminhao->ano_fabricacao }}
            </p>
        </div>
        
        <!-- Badge de Status -->
        <span class="px-3 py-1 text-xs font-semibold text-white rounded-full
            @switch($caminhao->status)
                @case('Em Trânsito') bg-blue-500 @break
                @case('Disponível') bg-green-500 @break
                @case('Em Manutenção') bg-yellow-500 @break
                @default bg-gray-400 @endswitch
        ">
            {{ $caminhao->status }}
        </span>
    </div>

    <!-- Rodapé com Botões de Ação -->
    <div class="border-t border-gray-200 pt-4 mt-4 flex justify-between items-center">
        <!-- Botões de Ação Direta -->
        <div class="flex space-x-2">
            <a href="{{  route('caminhoes.edit', $caminhao->id)  }}" class="flex items-center text-sm text-gray-600 hover:text-indigo-600 font-medium p-2 rounded-md hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                Editar caminhão
            </a>
            <!-- Botão para Histórico de Viagens -->
            <a href="{{ route('caminhoes.viagens.index', $caminhao->id) }}" class="flex items-center text-sm text-gray-600 hover:text-purple-600 font-medium p-2 rounded-md hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>
                Histórico de viagens
            </a>
            {{-- <a href="{{ route('viagens.create', $caminhao->id) }}" class="flex items-center text-sm text-gray-600 hover:text-green-600 font-medium p-2 rounded-md hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Visualizar viagens anteriores
            </a> --}}
        </div>
        
    </div>
    
    @if ($viagemAtiva = $caminhao->viagens->first())
        <div class="bg-gray-50 p-4 mt-4 rounded-md border border-gray-200">
            <h4 class="font-bold text-md mb-3 text-gray-700">Viagem em Andamento</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Origem</p>
                    <p class="font-semibold">{{ $viagemAtiva->origem->name }} - {{ $viagemAtiva->origem->state->abbr }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Destino</p>
                    <p class="font-semibold">{{ $viagemAtiva->destino->name }} - {{ $viagemAtiva->destino->state->abbr }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Início</p>
                    <p class="font-semibold">{{ \Carbon\Carbon::parse($viagemAtiva->dataInicio)->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200 flex justify-end">
                <a href="/viagens/{{ $viagemAtiva->id }}/editar" class="text-sm bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Gerenciar Viagem
                </a>
            </div>
        </div>
    @else
    {{-- Caso contrário (Disponível ou Manutenção), mostra um painel informativo --}}
    <div class="bg-gray-50 p-4 mt-4 rounded-md border border-gray-200 text-center">
        <p class="text-sm text-gray-500">Nenhuma viagem ativa encontrada para este caminhão.</p>
        
        {{-- Mostra o botão "Nova Viagem" apenas se o caminhão estiver disponível --}}
        
            <div class="mt-4">
                <a href="{{ route('viagens.create', $caminhao->id) }}" class="inline-flex items-center text-sm bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Iniciar Nova Viagem
                </a>
            </div>
        
    </div>
    @endif
</div>