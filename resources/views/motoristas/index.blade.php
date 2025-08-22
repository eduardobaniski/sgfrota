@extends('layout')

@section('title', 'Gerir Motoristas')

@section('content')
    {{-- Cabeçalho da Página --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gerir Motoristas</h1>
        <a href="{{ route('motorista.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Adicionar Novo Motorista
        </a>
    </div>

    {{-- Mensagem de Sucesso --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Card que envolve a tabela --}}
    <div class="bg-white p-8 rounded-lg shadow-md">
        
        <!-- Barra de Pesquisa -->
        <div class="mb-4">
            <form action="{{ route('motorista.index') }}" method="GET">
                <input type="text" name="search" placeholder="Pesquisar por nome, CPF ou CNH..." 
                       class="w-full p-2 border rounded-md" 
                       value="{{ request('search') }}">
            </form>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNH</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Ações</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($motoristas as $motorista)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $motorista->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $motorista->cpf }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $motorista->cnh }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                            <div class="flex justify-end items-center space-x-4">
                                <a href="{{ route('motorista.edit', $motorista->id) }}" class="inline-flex items-center bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-medium py-2 px-3 rounded-md transition-colors">
                                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    </svg>
                                    Editar
                                </a>
                                <x-delete :action="route('motorista.destroy', $motorista->id)" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
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
