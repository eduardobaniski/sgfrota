@extends('layout')

@section('title', 'Gerenciar Motoristas')

@section('content')
    {{-- Cabeçalho da Página --}}
    
    {{-- Mensagem de Sucesso --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Card que envolve a tabela --}}
    <div class="bg-white p-8 rounded-lg shadow-md">
        <div class="flex justify-end items-center mb-6">
            <a href="{{ route('motorista.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Adicionar Novo Motorista
            </a>
        </div>
        
        <!-- Filtros e Pesquisa -->
        <div class="mb-4">
            <form action="{{ route('motorista.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <input type="text" name="search" placeholder="Pesquisar por nome, CPF ou CNH..." 
                       class="p-2 border rounded-md w-64" 
                       value="{{ request('search') }}">
                <select name="status" class="p-2 border rounded-md">
                    @php $statusSel = request('status', $status ?? 'ativos'); @endphp
                    <option value="ativos" {{ $statusSel === 'ativos' ? 'selected' : '' }}>Ativos</option>
                    <option value="inativos" {{ $statusSel === 'inativos' ? 'selected' : '' }}>Inativos</option>
                    <option value="todos" {{ $statusSel === 'todos' ? 'selected' : '' }}>Todos</option>
                </select>
                <select name="cnh_status" class="p-2 border rounded-md">
                    @php $cnhSel = request('cnh_status', $cnh_status ?? 'todas'); @endphp
                    <option value="todas" {{ $cnhSel === 'todas' ? 'selected' : '' }}>CNH: Todas</option>
                    <option value="vencidas" {{ $cnhSel === 'vencidas' ? 'selected' : '' }}>CNH: Vencidas</option>
                    <option value="vence30" {{ $cnhSel === 'vence30' ? 'selected' : '' }}>CNH: Vence em 30 dias</option>
                    <option value="validas" {{ $cnhSel === 'validas' ? 'selected' : '' }}>CNH: Válidas (+30d)</option>
                </select>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filtrar</button>
                @if(request()->filled('search') || request()->filled('status') || request()->filled('cnh_status'))
                    <a href="{{ route('motorista.index') }}" class="text-sm text-gray-600 underline">Limpar</a>
                @endif
            </form>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNH</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validade CNH</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Ações</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($motoristas as $motorista)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $motorista->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $motorista->cpf }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $motorista->cnh }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @php
                                $classe = 'text-gray-700 bg-gray-100';
                                $texto = $motorista->cnh_validade ? $motorista->cnh_validade->format('d/m/Y') : '-';
                                if ($motorista->cnh_validade) {
                                    $dias = now()->startOfDay()->diffInDays($motorista->cnh_validade, false);
                                    if ($dias < 0) {
                                        $classe = 'text-red-800 bg-red-100';
                                        $texto = 'Expirada • ' . $motorista->cnh_validade->format('d/m/Y');
                                    } elseif ($dias <= 30) {
                                        $classe = 'text-yellow-800 bg-yellow-100';
                                        $texto = 'Vence em ' . $dias . ' dias • ' . $motorista->cnh_validade->format('d/m/Y');
                                    }
                                }
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $classe }}">
                                {{ $texto }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $motorista->telefone ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                            <div class="flex justify-end items-center space-x-4">
                                @if(method_exists($motorista, 'trashed') && $motorista->trashed())
                                    <form action="{{ route('motorista.restore', $motorista->id) }}" method="POST" onsubmit="return confirm('Restaurar este motorista?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-xs font-medium py-2 px-3 rounded-md transition-colors">
                                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 1112.546 5.303M4.5 12H9m-4.5 0V7.5" />
                                            </svg>
                                            Restaurar
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('motorista.edit', $motorista->id) }}" class="inline-flex items-center bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-medium py-2 px-3 rounded-md transition-colors">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                        </svg>
                                        Editar
                                    </a>
                                    <x-delete :action="route('motorista.destroy', $motorista->id)" />
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Nenhum motorista encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Links de Paginação --}}
        <div class="mt-6">
            {{ $motoristas->withQueryString()->links() }}
        </div>
    </div>
@endsection
